<?php

namespace App\ShoppingList\Infrastructure\Factory;

use App\ShoppingList\Domain\Entity\ShoppingList;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<ShoppingList>
 */
final class ShoppingListFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return ShoppingList::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->words(2, true),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
