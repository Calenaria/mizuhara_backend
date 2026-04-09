<?php

namespace App\Inventory\Domain\Repository;

use App\Inventory\Domain\Entity\SupplySource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SupplySource>
 */
class SupplySourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupplySource::class);
    }
}
