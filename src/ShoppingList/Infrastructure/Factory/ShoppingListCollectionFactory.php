<?php

namespace App\ShoppingList\Infrastructure\Factory;

use App\Shared\Infrastructure\Factory\UserFactory;
use App\ShoppingList\Domain\Entity\ShoppingListCollection;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<ShoppingListCollection>
 */
final class ShoppingListCollectionFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return ShoppingListCollection::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->words(3, true),
            'owner' => UserFactory::new(),
            'description' => self::faker()->optional()->sentence(),
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
