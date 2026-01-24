<?php

namespace App\ShoppingList\Infrastructure\Factory;

use App\Shared\Infrastructure\Factory\ProductInformationFactory;
use App\ShoppingList\Domain\Entity\ShoppingListEntry;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<ShoppingListEntry>
 */
final class ShoppingListEntryFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return ShoppingListEntry::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'productInformation' => ProductInformationFactory::new(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'acquired' => false,
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
