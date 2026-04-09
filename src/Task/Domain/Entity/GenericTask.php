<?php

namespace App\Task\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\User;
use App\Task\Domain\Enum\TaskStatus;
use App\Task\Domain\Repository\GenericTaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GenericTaskRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['generic_task:read']],
    denormalizationContext: ['groups' => ['generic_task:write']],
)]
class GenericTask extends BaseEntity
{
    #[Groups(['generic_task:read'])]
    #[ORM\ManyToOne(inversedBy: 'genericTasks')]
    private ?User $assignee = null;

    #[Groups(['generic_task:read'])]
    #[ORM\OneToMany(targetEntity: TaskEntry::class, mappedBy: 'task', cascade: ['persist', 'remove'])]
    private Collection $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
        parent::__construct();
    }

    #[Groups(['generic_task:read'])]
    #[ORM\Column(enumType: TaskStatus::class)]
    private ?TaskStatus $status = TaskStatus::NEW;

    #[Groups(['generic_task:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    #[Groups(['generic_task:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $startedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getStatus(): ?TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?\DateTimeImmutable $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function markInProgress(): static
    {
        if ($this->status === TaskStatus::NEW) {
            $this->status = TaskStatus::IN_PROGRESS;
            $this->startedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function complete(): static
    {
        $this->status = TaskStatus::COMPLETED;
        $this->completedAt = new \DateTimeImmutable();

        return $this;
    }

    public function allEntriesCompleted(): bool
    {
        if ($this->entries->isEmpty()) {
            return false;
        }

        foreach ($this->entries as $entry) {
            if (!$entry->isCompleted()) {
                return false;
            }
        }

        return true;
    }

    /** @return Collection<int, TaskEntry> */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(TaskEntry $entry): static
    {
        if (!$this->entries->contains($entry)) {
            $this->entries->add($entry);
            $entry->setTask($this);
        }

        return $this;
    }

    public function removeEntry(TaskEntry $entry): static
    {
        if ($this->entries->removeElement($entry)) {
            if ($entry->getTask() === $this) {
                $entry->setTask(null);
            }
        }

        return $this;
    }
}
