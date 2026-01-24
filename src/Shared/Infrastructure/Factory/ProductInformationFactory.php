<?php

namespace App\Shared\Infrastructure\Factory;

use App\Shared\Domain\Entity\ProductInformation;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<ProductInformation>
 */
final class ProductInformationFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return ProductInformation::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'brand' => ProductBrandFactory::new(),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
