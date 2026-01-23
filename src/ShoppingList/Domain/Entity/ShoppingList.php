<?php

namespace App\ShoppingList\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\User;
use App\ShoppingList\Domain\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingList extends BaseEntity
{
    #[ORM\ManyToOne(inversedBy: 'shoppingLists')]
    private ?ShoppingListCollection $shoppingListCollection = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingLists')]
    private ?User $addedBy = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ShoppingListEntry>
     */
    #[ORM\OneToMany(targetEntity: ShoppingListEntry::class, mappedBy: 'shoppingList', orphanRemoval: true)]
    private Collection $shoppingListEntries;

    public function __construct()
    {
        $this->shoppingListEntries = new ArrayCollection();
    }

    public function getShoppingListCollection(): ?ShoppingListCollection
    {
        return $this->shoppingListCollection;
    }

    public function setShoppingListCollection(?ShoppingListCollection $shoppingListCollection): static
    {
        $this->shoppingListCollection = $shoppingListCollection;

        return $this;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): static
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $shoppingListEntry->setShoppingList($this);
        }

        return $this;
    }

    public function removeShoppingListEntry(ShoppingListEntry $shoppingListEntry): static
    {
        if ($this->shoppingListEntries->removeElement($shoppingListEntry)) {
            // set the owning side to null (unless already changed)
            if ($shoppingListEntry->getShoppingList() === $this) {
                $shoppingListEntry->setShoppingList(null);
            }
        }

        return $this;
    }
}
