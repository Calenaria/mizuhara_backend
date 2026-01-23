<?php

namespace App\ShoppingList\Domain\Repository;

use App\ShoppingList\Domain\Entity\ShoppingList;
use App\ShoppingList\Domain\Entity\ShoppingListEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingList>
 */
class ShoppingListEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingListEntry::class);
    }
}
