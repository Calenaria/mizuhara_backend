<?php

namespace App\Shared\Infrastructure\DataFixtures;

use App\Shared\Domain\Entity\ProductInformation;
use App\Shared\Infrastructure\Factory\UserFactory;
use App\ShoppingList\Infrastructure\Factory\ShoppingListCollectionFactory;
use App\ShoppingList\Infrastructure\Factory\ShoppingListFactory;
use App\ShoppingList\Infrastructure\Factory\ShoppingListEntryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = UserFactory::createOne();

        $products = $this->entityManager->getRepository(ProductInformation::class)
            ->findBy([], ['id' => 'ASC'], 100);

        if (empty($products)) {
            throw new \RuntimeException('No products found in database. Run the import command first.');
        }

        ShoppingListCollectionFactory::createMany(2, ['owner' => $user]);

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
                    function() use ($list, $products) {
                        // Pick a random product from the 100
                        $randomProduct = $products[array_rand($products)];

                        return [
                            'shoppingList' => $list,
                            'addedBy' => $list->getAddedBy(),
                            'productInformation' => $randomProduct, // Assuming ShoppingListEntry has this field
                        ];
                    }
                );
            }
        }
    }
}
