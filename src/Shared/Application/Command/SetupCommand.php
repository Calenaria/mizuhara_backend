<?php

namespace App\Shared\Application\Command;

use App\Shared\Domain\Service\ConfigurationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:setup',
    description: 'Initial application setup wizard',
)]
class SetupCommand extends Command
{
    public function __construct(
        private ConfigurationService $configService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->configService->isSetupComplete()) {
            if (!$io->confirm('Setup has already been completed. Run again?', false)) {
                return Command::SUCCESS;
            }
        }

        $io->title('Mizuhara Backend Setup');

        $appName = $io->ask(
            'Application name',
            'Mizuhara Household Manager'
        );
        $this->configService->set('app.name', $appName, 'string', 'Application display name');

        $timezone = $io->ask(
            'Default timezone',
            'Europe/Berlin'
        );
        $this->configService->set('app.timezone', $timezone, 'string', 'Application timezone');

        $io->section('Feature Configuration');

        $enableCalendar = $io->confirm('Enable Family Calendar module?', true);
        $this->configService->set('features.family_calendar', $enableCalendar, 'boolean');

        $enableShopping = $io->confirm('Enable Shopping List module?', true);
        $this->configService->set('features.shopping_list', $enableShopping, 'boolean');

        $io->section('Default Settings');

        $currencyCode = $io->ask('Default currency code', 'EUR');
        $this->configService->set('app.currency', $currencyCode, 'string');

        $locale = $io->ask('Default locale', 'de_DE');
        $this->configService->set('app.locale', $locale, 'string');

        $this->configService->set('app.setup_complete', true, 'boolean', 'Whether initial setup has been completed');

        $io->success('Setup completed successfully!');
        $io->info([
            'You can reconfigure these settings at any time by:',
            '  - Running: php bin/console app:setup',
            '  - Using the admin panel',
            '  - Directly modifying the app_configuration table',
        ]);

        return Command::SUCCESS;
    }
}
