<?php

namespace App\Task\Infrastructure\Factory;

use App\Task\Domain\Entity\GenericTask;
use App\Task\Domain\Enum\TaskStatus;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<GenericTask>
 */
final class GenericTaskFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return GenericTask::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'status' => TaskStatus::NEW,
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
