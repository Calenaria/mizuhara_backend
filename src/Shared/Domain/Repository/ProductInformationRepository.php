<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\ProductInformation;
use App\ShoppingList\Domain\Entity\ShoppingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingList>
 */
class ProductInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductInformation::class);
    }
}
