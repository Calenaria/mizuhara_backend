<?php

namespace App\Task\Domain\Repository;

use App\Task\Domain\Entity\GenericTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GenericTask>
 */
class GenericTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenericTask::class);
    }
}
