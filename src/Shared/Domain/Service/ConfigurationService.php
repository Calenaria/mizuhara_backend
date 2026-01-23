<?php

namespace App\Shared\Domain\Service;

use App\Shared\Domain\Entity\AppConfiguration;
use Doctrine\ORM\EntityManagerInterface;

class ConfigurationService
{
    private array $cache = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function get(string $key, mixed $default = null): mixed
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $config = $this->entityManager
            ->getRepository(AppConfiguration::class)
            ->findOneBy(['key' => $key]);

        if (!$config) {
            return $default;
        }

        $this->cache[$key] = $config->getTypedValue();
        return $this->cache[$key];
    }

    public function set(string $key, mixed $value, string $type = 'string', ?string $description = null): void
    {
        $config = $this->entityManager
            ->getRepository(AppConfiguration::class)
            ->findOneBy(['key' => $key]);

        if (!$config) {
            $config = new AppConfiguration($key);
        }

        $config->setValue($this->serializeValue($value, $type));
        $config->setType($type);

        if ($description !== null) {
            $config->setDescription($description);
        }

        $this->entityManager->persist($config);
        $this->entityManager->flush();

        unset($this->cache[$key]);
    }

    public function isSetupComplete(): bool
    {
        return (bool) $this->get('app.setup_complete', false);
    }

    private function serializeValue(mixed $value, string $type): string
    {
        return match($type) {
            'json' => json_encode($value),
            'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };
    }
}
