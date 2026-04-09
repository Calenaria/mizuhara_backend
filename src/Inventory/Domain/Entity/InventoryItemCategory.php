<?php

namespace App\Inventory\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Inventory\Domain\Repository\InventoryItemCategoryRepository;
use App\Shared\Domain\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryItemCategoryRepository::class)]
#[ApiResource]
class InventoryItemCategory extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private ?string $categoryName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }
}
