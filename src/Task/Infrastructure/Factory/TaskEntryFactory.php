<?php

namespace App\Task\Infrastructure\Factory;

use App\Task\Domain\Entity\TaskEntry;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<TaskEntry>
 */
final class TaskEntryFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return TaskEntry::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'description' => self::faker()->sentence(),
            'sortOrder' => self::faker()->numberBetween(0, 10),
            'task' => GenericTaskFactory::new(),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
