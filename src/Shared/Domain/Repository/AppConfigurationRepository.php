<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\ProductBrand;
use App\ShoppingList\Domain\Entity\ShoppingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingList>
 */
class AppConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppConfigurationRepository::class);
    }

}
