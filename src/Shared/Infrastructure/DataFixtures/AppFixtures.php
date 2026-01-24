<?php

namespace App\Shared\Infrastructure\DataFixtures;

use App\Shared\Infrastructure\Factory\UserFactory;
use App\Shared\Infrastructure\Factory\ProductInformationFactory;
use App\ShoppingList\Infrastructure\Factory\ShoppingListCollectionFactory;
use App\ShoppingList\Infrastructure\Factory\ShoppingListFactory;
use App\ShoppingList\Infrastructure\Factory\ShoppingListEntryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = UserFactory::createMany(5);

        ProductInformationFactory::createMany(20);

        foreach ($users as $user) {
            ShoppingListCollectionFactory::createMany(2, function() use ($user) {
                return ['owner' => $user];
            });
        }

        $collections = ShoppingListCollectionFactory::all();

        foreach ($collections as $collection) {
            $lists = ShoppingListFactory::createMany(
                3,
                function() use ($collection) {
                    return [
                        'shoppingListCollection' => $collection,
                        'addedBy' => $collection->getOwner(),
                    ];
                }
            );

            foreach ($lists as $list) {
                ShoppingListEntryFactory::createMany(
                    5,
                    function() use ($list) {
                        return [
                            'shoppingList' => $list,
                            'addedBy' => $list->getAddedBy(),
                        ];
                    }
                );
            }
        }
    }
}
