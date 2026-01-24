<?php

namespace App\Shared\Application\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:product:process:csv',
    description: 'Filters German products out of the OFF CSV file',
)]
class ProcessCsvDataCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('input', InputArgument::REQUIRED, 'Input CSV file')
            ->addArgument('output', InputArgument::REQUIRED, 'Output CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputPath = $input->getArgument('input');
        $outputPath = $input->getArgument('output');

        if (!file_exists($inputPath)) {
            $io->error("Input file not found: {$inputPath}");
            return Command::FAILURE;
        }

        $io->title('Extracting German Products');

        $inputFile = new \SplFileObject($inputPath, 'r');
        $inputFile->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
        $inputFile->setCsvControl("\t");

        $outputFile = new \SplFileObject($outputPath, 'w');

        $header = $inputFile->current();
        $inputFile->next();

        $columnMap = array_flip($header);

        if (!isset($columnMap['countries_en'])) {
            $io->error('Column "countries_en" not found in CSV');
            return Command::FAILURE;
        }

        $outputFile->fputcsv($header, "\t");

        $countryIndex = $columnMap['countries_en'];
        $germanCount = 0;
        $totalCount = 0;

        $io->text('Processing CSV...');
        $progressBar = new ProgressBar($output, 4_294_491);
        $progressBar->setFormat('debug');
        $progressBar->start();

        foreach ($inputFile as $lineNum => $row) {
            if ($lineNum === 0) continue;

            $totalCount++;
            $country = $row[$countryIndex] ?? '';

            if (stripos($country, 'Germany') !== false) {
                $outputFile->fputcsv($row, "\t");
                $germanCount++;
            }

            if ($totalCount % 10000 === 0) {
                $progressBar->advance(10000);
            }
        }

        $progressBar->finish();
        $io->newLine(2);

        $io->success('Extraction complete!');

        $io->table(
            ['Metric', 'Value'],
            [
                ['Total rows processed', number_format($totalCount)],
                ['German products extracted', number_format($germanCount)],
                ['Output file', $outputPath],
                ['File size', $this->formatBytes(filesize($outputPath))],
            ]
        );

        return Command::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
