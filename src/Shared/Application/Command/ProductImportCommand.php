<?php

namespace App\Shared\Application\Command;

use App\Shared\Domain\Entity\ProductBrand;
use App\Shared\Domain\Entity\ProductInformation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:product:import',
    description: 'Imports product information from a CSV file',
)]
class ProductImportCommand extends Command
{
    private const int BATCH_SIZE = 500;

    private array $brandCache = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to CSV file')
            ->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Limit number of products to import', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('file');
        $limit = $input->getOption('limit');

        if (!file_exists($filePath)) {
            $io->error("File not found: {$filePath}");
            return Command::FAILURE;
        }

        $io->title('Importing Products from CSV');

        $file = new \SplFileObject($filePath, 'r');
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
        $file->setCsvControl("\t");

        $header = $file->current();
        $file->next();
        $columnMap = array_flip($header);

        $io->text('Columns found: ' . count($columnMap));

        $imported = 0;
        $skipped = 0;
        $batch = [];

        $progressBar = new ProgressBar($output, $limit ?? 383372);
        $progressBar->setFormat('debug');
        $progressBar->start();

        foreach ($file as $lineNum => $row) {
            if ($lineNum === 0) continue;

            $code = trim($row[$columnMap['code']] ?? '');
            if (empty($code)) {
                $skipped++;
                continue;
            }

            $existing = $this->entityManager->getRepository(ProductInformation::class)
                ->findOneBy(['code' => $code]);

            if ($existing) {
                $skipped++;
                $progressBar->advance();
                continue;
            }

            $product = new ProductInformation();
            $product->setCode($code);

            $brandName = trim($row[$columnMap['brands']] ?? '');
            if (!empty($brandName)) {
                $brands = explode(',', $brandName);
                $brandName = trim($brands[0]);

                $brand = $this->getOrCreateBrand($brandName);
                $product->setBrand($brand);
            }

            $this->mapFields($product, $row, $columnMap);

            $batch[] = $product;
            $imported++;

            if (count($batch) >= self::BATCH_SIZE) {
                $this->flushBatch($batch);
                $batch = [];
                $progressBar->advance(self::BATCH_SIZE);
            }

            if ($limit && $imported >= $limit) {
                break;
            }
        }

        if (!empty($batch)) {
            $this->flushBatch($batch);
            $progressBar->advance(count($batch));
        }

        $progressBar->finish();
        $io->newLine(2);

        $io->success('Import complete!');
        $io->table(
            ['Metric', 'Count'],
            [
                ['Products imported', number_format($imported)],
                ['Products skipped', number_format($skipped)],
                ['Brands created', number_format(count($this->brandCache))],
            ]
        );

        return Command::SUCCESS;
    }

    private function getOrCreateBrand(string $brandName): ProductBrand
    {
        if (isset($this->brandCache[$brandName])) {
            $cachedBrand = $this->brandCache[$brandName];

            if (!$this->entityManager->contains($cachedBrand)) {
                $brand = $this->entityManager->getRepository(ProductBrand::class)
                    ->findOneBy(['name' => $brandName]);

                if ($brand) {
                    $this->brandCache[$brandName] = $brand;
                    return $brand;
                }
            } else {
                return $cachedBrand;
            }
        }

        $brand = $this->entityManager->getRepository(ProductBrand::class)
            ->findOneBy(['name' => $brandName]);

        if (!$brand) {
            $brand = new ProductBrand();
            $brand->setName($brandName);
            $this->entityManager->persist($brand);
            $this->entityManager->flush();
        }

        $this->brandCache[$brandName] = $brand;
        return $brand;
    }

    private function mapFields(ProductInformation $product, array $row, array $columnMap): void
    {
        $product->setProductName($this->getValue($row, $columnMap, 'product_name'));
        $product->setGenericName($this->getValue($row, $columnMap, 'generic_name'));
        $product->setBrandOwner($this->getValue($row, $columnMap, 'brand_owner'));
        $product->setQuantity($this->getValue($row, $columnMap, 'quantity'));
        $product->setProductQuantity($this->getValue($row, $columnMap, 'product_quantity'));
        $product->setPackaging($this->getValue($row, $columnMap, 'packaging'));
        $product->setCategories($this->getValue($row, $columnMap, 'categories'));
        $product->setCategoriesTags($this->getValue($row, $columnMap, 'categories_tags'));
        $product->setMainCategory($this->getValue($row, $columnMap, 'main_category'));
        $product->setFoodGroups($this->getValue($row, $columnMap, 'food_groups'));
        $product->setPnnsGroups1($this->getValue($row, $columnMap, 'pnns_groups_1'));
        $product->setPnnsGroups2($this->getValue($row, $columnMap, 'pnns_groups_2'));
        $product->setIngredientsText($this->getValue($row, $columnMap, 'ingredients_text'));
        $product->setIngredientsTags($this->getValue($row, $columnMap, 'ingredients_tags'));
        $product->setIngredientsAnalysisTags($this->getValue($row, $columnMap, 'ingredients_analysis_tags'));
        $product->setLabels($this->getValue($row, $columnMap, 'labels'));
        $product->setLabelsTags($this->getValue($row, $columnMap, 'labels_tags'));
        $product->setAllergens($this->getValue($row, $columnMap, 'allergens'));
        $product->setStores($this->getValue($row, $columnMap, 'stores'));
        $product->setPurchasePlaces($this->getValue($row, $columnMap, 'purchase_places'));
        $product->setCountries($this->getValue($row, $columnMap, 'countries'));
        $product->setEnvironmentalScoreGrade($this->getValue($row, $columnMap, 'environmental_score_grade'));
        $product->setImageUrl($this->getValue($row, $columnMap, 'image_url'));

        $product->setEnergyKcal100g($this->getNumericValue($row, $columnMap, 'energy-kcal_100g'));
        $product->setProteins100g($this->getNumericValue($row, $columnMap, 'proteins_100g'));
        $product->setFat100g($this->getNumericValue($row, $columnMap, 'fat_100g'));
        $product->setCarbohydrates100g($this->getNumericValue($row, $columnMap, 'carbohydrates_100g'));
        $product->setFiber100g($this->getNumericValue($row, $columnMap, 'fiber_100g'));
        $product->setVitaminB12100g($this->getNumericValue($row, $columnMap, 'vitamin-b12_100g'));
        $product->setIron100g($this->getNumericValue($row, $columnMap, 'iron_100g'));
        $product->setCalcium100g($this->getNumericValue($row, $columnMap, 'calcium_100g'));

        $envScore = $this->getValue($row, $columnMap, 'environmental_score_score');
        if ($envScore !== null && is_numeric($envScore)) {
            $product->setEnvironmentalScoreScore((int) $envScore);
        }
    }

    private function getValue(array $row, array $columnMap, string $columnName): ?string
    {
        if (!isset($columnMap[$columnName])) {
            return null;
        }

        $value = trim($row[$columnMap[$columnName]] ?? '');
        return $value === '' ? null : $value;
    }

    private function getNumericValue(array $row, array $columnMap, string $columnName): ?string
    {
        $value = $this->getValue($row, $columnMap, $columnName);
        if ($value === null || !is_numeric($value)) {
            return null;
        }
        return $value;
    }

    private function flushBatch(array $batch): void
    {
        foreach ($batch as $product) {
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
        $this->entityManager->clear(ProductInformation::class);
        $this->brandCache = [];

        gc_collect_cycles();
    }
}
