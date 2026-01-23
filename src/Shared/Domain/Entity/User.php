<?php

namespace App\Shared\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\ShoppingList\Domain\Entity\ShoppingList;
use App\ShoppingList\Domain\Entity\ShoppingListEntry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class User extends BaseEntity
{
    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $username;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isActive = true;

    /**
     * @var Collection<int, ShoppingList>
     */
    #[ORM\OneToMany(targetEntity: ShoppingList::class, mappedBy: 'addedBy')]
    private Collection $shoppingLists;

    /**
     * @var Collection<int, ShoppingListEntry>
     */
    #[ORM\OneToMany(targetEntity: ShoppingListEntry::class, mappedBy: 'addedBy')]
    private Collection $shoppingListEntries;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->shoppingLists = new ArrayCollection();
        $this->shoppingListEntries = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return Collection<int, ShoppingList>
     */
    public function getShoppingLists(): Collection
    {
        return $this->shoppingLists;
    }

    public function addShoppingList(ShoppingList $shoppingList): static
    {
        if (!$this->shoppingLists->contains($shoppingList)) {
            $this->shoppingLists->add($shoppingList);
            $shoppingList->setAddedBy($this);
        }

        return $this;
    }

    public function removeShoppingList(ShoppingList $shoppingList): static
    {
        if ($this->shoppingLists->removeElement($shoppingList)) {
            // set the owning side to null (unless already changed)
            if ($shoppingList->getAddedBy() === $this) {
                $shoppingList->setAddedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShoppingListEntry>
     */
    public function getShoppingListEntries(): Collection
    {
        return $this->shoppingListEntries;
    }

    public function addShoppingListEntry(ShoppingListEntry $shoppingListEntry): static
    {
        if (!$this->shoppingListEntries->contains($shoppingListEntry)) {
            $this->shoppingListEntries->add($shoppingListEntry);
            $shoppingListEntry->setAddedBy($this);
        }

        return $this;
    }

    public function removeShoppingListEntry(ShoppingListEntry $shoppingListEntry): static
    {
        if ($this->shoppingListEntries->removeElement($shoppingListEntry)) {
            // set the owning side to null (unless already changed)
            if ($shoppingListEntry->getAddedBy() === $this) {
                $shoppingListEntry->setAddedBy(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }
}
