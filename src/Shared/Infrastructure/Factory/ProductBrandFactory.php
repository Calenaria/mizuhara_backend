<?php

namespace App\Shared\Infrastructure\Factory;

use App\Shared\Domain\Entity\ProductBrand;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<ProductBrand>
 */
final class ProductBrandFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return ProductBrand::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => self::faker()->name(),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
