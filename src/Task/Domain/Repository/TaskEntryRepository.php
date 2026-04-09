<?php

namespace App\Task\Domain\Repository;

use App\Task\Domain\Entity\TaskEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskEntry>
 */
class TaskEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskEntry::class);
    }
}
