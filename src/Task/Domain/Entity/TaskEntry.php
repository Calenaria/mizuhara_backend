<?php

namespace App\Task\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\User;
use App\Task\Application\Processor\CompleteTaskEntryProcessor;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\Repository\TaskEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
        new Post(
            uriTemplate: '/task_entries/{id}/complete',
            normalizationContext: ['groups' => ['task_entry:read']],
            deserialize: false,
            processor: CompleteTaskEntryProcessor::class,
        ),
    ],
    normalizationContext: ['groups' => ['task_entry:read']],
    denormalizationContext: ['groups' => ['task_entry:write']],
)]
#[ORM\Entity(repositoryClass: TaskEntryRepository::class)]
class TaskEntry extends BaseEntity
{
    #[Groups(['task_entry:write'])]
    #[ORM\ManyToOne(inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GenericTask $task = null;

    #[Groups(['task_entry:read', 'task_entry:write', 'generic_task:read'])]
    #[ORM\Column(length: 255)]
    private string $description;

    #[Groups(['task_entry:read', 'task_entry:write', 'generic_task:read'])]
    #[ORM\Column]
    private int $sortOrder = 0;

    #[Groups(['task_entry:read', 'generic_task:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    #[Groups(['task_entry:read', 'generic_task:read'])]
    #[ORM\ManyToOne]
    private ?User $completedBy = null;

    public function __construct(string $description, int $sortOrder = 0)
    {
        $this->description = $description;
        $this->sortOrder = $sortOrder;
        parent::__construct();
    }

    public function getTask(): ?GenericTask
    {
        return $this->task;
    }

    public function setTask(?GenericTask $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function getCompletedBy(): ?User
    {
        return $this->completedBy;
    }

    public function complete(?User $completedBy = null): static
    {
        $this->completedAt = new \DateTimeImmutable();
        $this->completedBy = $completedBy;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completedAt !== null;
    }
}
