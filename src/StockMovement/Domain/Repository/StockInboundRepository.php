<?php

namespace App\StockMovement\Domain\Repository;

use App\StockMovement\Domain\Entity\StockInbound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockInbound>
 */
class StockInboundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockInbound::class);
    }
}
