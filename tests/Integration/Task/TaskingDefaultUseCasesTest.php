<?php

namespace App\Tests\Integration\Task;

use ApiPlatform\Metadata\Patch;
use App\Task\Application\Processor\CompleteTaskEntryProcessor;
use App\Task\Domain\Entity\GenericTask;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Infrastructure\Factory\GenericTaskFactory;
use App\Task\Infrastructure\Factory\TaskEntryFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;

#[ResetDatabase]
class TaskingDefaultUseCasesTest extends KernelTestCase
{
    private CompleteTaskEntryProcessor $completeTaskEntryProcessor;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $this->completeTaskEntryProcessor = new CompleteTaskEntryProcessor($this->entityManager);
        parent::setUp();
    }

    public function testCreateNewTaskAndCheckOffOneEntryToMakeInProgress(): void
    {
        $task = GenericTaskFactory::createOne([
            'status' => TaskStatus::NEW,
        ]);

        $entryToBeCompleted = TaskEntryFactory::createOne([
            'task' => $task,
        ]);

        $entryToBeUntouched = TaskEntryFactory::createOne([
            'task' => $task,
        ]);

        $this->assertSame(TaskStatus::NEW, $task->getStatus());
        $this->assertFalse($entryToBeCompleted->isCompleted());
        $this->assertFalse($entryToBeUntouched->isCompleted());

        $this->completeTaskEntryProcessor->process(
            data: $entryToBeCompleted,
            operation: new Patch(),
        );

        $this->entityManager->clear();

        $freshTask = $this->entityManager->find(GenericTask::class, $task->getId());

        $this->assertSame(TaskStatus::IN_PROGRESS, $freshTask->getStatus());
        $this->assertNotNull($freshTask->getStartedAt());
        $this->assertNull($freshTask->getCompletedAt());
    }
}
