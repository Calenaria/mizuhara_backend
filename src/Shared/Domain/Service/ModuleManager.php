<?php

namespace App\Shared\Domain\Service;

use App\Shared\Domain\Entity\AppConfiguration;
use Doctrine\ORM\EntityManagerInterface;

class ModuleManager
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function isModuleEnabled(string $moduleName): bool
    {
        $config = $this->entityManager
            ->getRepository(AppConfiguration::class)
            ->findOneBy(['key' => 'features.' . strtolower($moduleName)]);

        return $config?->getTypedValue() === true;
    }
}
