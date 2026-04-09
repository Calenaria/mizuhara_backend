<?php

namespace App\Inventory\Domain\Repository;

use App\Inventory\Domain\Entity\InventoryStockItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventoryStockItem>
 */
class InventoryStockItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryStockItem::class);
    }
}
