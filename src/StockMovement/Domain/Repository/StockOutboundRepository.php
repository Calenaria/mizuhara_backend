<?php

namespace App\StockMovement\Domain\Repository;

use App\StockMovement\Domain\Entity\StockOutbound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockOutbound>
 */
class StockOutboundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockOutbound::class);
    }
}
