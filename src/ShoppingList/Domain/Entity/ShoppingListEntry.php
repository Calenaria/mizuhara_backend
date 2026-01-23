<?php

namespace App\ShoppingList\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\ProductInformation;
use App\Shared\Domain\Entity\User;
use App\ShoppingList\Domain\Repository\ShoppingListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingListEntry extends BaseEntity
{
    #[ORM\ManyToOne(inversedBy: 'shoppingListEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShoppingList $shoppingList = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductInformation $productInformation = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingListEntries')]
    private ?User $addedBy = null;

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
}
