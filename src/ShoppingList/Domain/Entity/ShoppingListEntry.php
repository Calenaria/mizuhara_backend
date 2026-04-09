<?php

namespace App\ShoppingList\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\ProductInformation;
use App\Shared\Domain\Entity\User;
use App\ShoppingList\Domain\Repository\ShoppingListEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['shopping_list_entry:read']],
    denormalizationContext: ['groups' => ['shopping_list_entry:write']]
)]
#[ORM\Entity(repositoryClass: ShoppingListEntryRepository::class)]
class ShoppingListEntry extends BaseEntity
{
    #[Groups(['shopping_list_entry:write'])]
    #[ORM\ManyToOne(inversedBy: 'shoppingListEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShoppingList $shoppingList = null;

    #[Groups(['shopping_list:read', 'shopping_list_entry:read', 'shopping_list_entry:write', 'shopping_list_collection:read'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductInformation $productInformation = null;

    #[Groups(['shopping_list:read', 'shopping_list_entry:read', 'shopping_list_entry:write', 'shopping_list_collection:read'])]
    #[ORM\ManyToOne(inversedBy: 'shoppingListEntries')]
    private ?User $addedBy = null;

    #[Groups(['shopping_list:read', 'shopping_list_entry:read', 'shopping_list_entry:write', 'shopping_list_collection:read'])]
    #[ORM\Column(nullable: false)]
    private bool $acquired;
    #[Groups(['shopping_list:read', 'shopping_list_entry:read', 'shopping_list_entry:write', 'shopping_list_collection:read'])]
    #[ORM\Column]
    private int $quantity;

    public function __construct()
    {
        $this->acquired = false;
        $this->quantity = 1;
        parent::__construct();
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): static
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }

    public function getProductInformation(): ?ProductInformation
    {
        return $this->productInformation;
    }

    public function setProductInformation(?ProductInformation $productInformation): static
    {
        $this->productInformation = $productInformation;

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

    public function isAcquired(): bool
    {
        return $this->acquired;
    }

    public function setAcquired(bool $acquired): static
    {
        $this->acquired = $acquired;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
