<?php

namespace App\Shared\Application\Service;

use App\Shared\Domain\Entity\ProductInformation;
use App\Shared\Domain\Repository\ProductInformationRepository;
use App\Shared\Domain\Service\FoodFactsClientInterface;
use App\Shared\Domain\Service\OpenFoodFactsProductDTO;
use Doctrine\ORM\EntityManagerInterface;

readonly class ProductResolver
{
    public function __construct(
        private FoodFactsClientInterface     $foodFactsClient,
        private ProductInformationRepository $productInformationRepository,
        private EntityManagerInterface       $entityManager,
    ) {}

    public function resolveByEan(string $ean): ?ProductInformation
    {
        $product = $this->productInformationRepository->findOneBy(['code' => $ean]);

        if ($product !== null) {
            return $product;
        }

        $dto = $this->foodFactsClient->getProductByEan($ean);

        if ($dto === null) {
            return null;
        }

        if ($dto->genericName !== null) {
            $product = $this->productInformationRepository->findOneBy(['genericName' => $dto->genericName]);

            if ($product !== null) {
                return $product;
            }
        }

        return $this->createFromDto($ean, $dto);
    }

    private function createFromDto(string $ean, OpenFoodFactsProductDTO $dto): ProductInformation
    {
        $product = new ProductInformation();
        $product->setCode($ean);
        $product->setProductName($dto->productName);
        $product->setGenericName($dto->genericName);
        $product->setQuantity($dto->quantity);
        $product->setIngredientsText($dto->ingredientsText);
        $product->setAllergens($dto->allergens);
        $product->setImageUrl($dto->imageUrl);
        $product->setLabels($dto->labels);
        $product->setEnergyKcal100g($dto->energyKcal100g !== null ? (string) $dto->energyKcal100g : null);
        $product->setProteins100g($dto->proteins100g !== null ? (string) $dto->proteins100g : null);
        $product->setFat100g($dto->fat100g !== null ? (string) $dto->fat100g : null);
        $product->setCarbohydrates100g($dto->carbohydrates100g !== null ? (string) $dto->carbohydrates100g : null);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}
