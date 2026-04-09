<?php

namespace App\Inventory\Domain\Repository;

use App\Inventory\Domain\Entity\ProductSupplySource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductSupplySource>
 */
class ProductSupplySourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductSupplySource::class);
    }
}
