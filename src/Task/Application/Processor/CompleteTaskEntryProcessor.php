<?php

namespace App\Task\Application\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Task\Domain\Entity\TaskEntry;
use Doctrine\ORM\EntityManagerInterface;

readonly class CompleteTaskEntryProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TaskEntry
    {
        if ($data instanceof TaskEntry && !$data->isCompleted()) {
            $data->complete();

            $task = $data->getTask();
            if ($task !== null) {
                $task->markInProgress();

                if ($task->allEntriesCompleted()) {
                    $task->complete();
                }
            }

            $this->entityManager->flush();
        }

        return $data;
    }
}
