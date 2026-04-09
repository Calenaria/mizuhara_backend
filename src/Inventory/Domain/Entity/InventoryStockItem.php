<?php

namespace App\Inventory\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Inventory\Domain\Repository\InventoryStockItemRepository;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\ProductInformation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: InventoryStockItemRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['inventory_stock_item:read']],
    denormalizationContext: ['groups' => ['inventory_stock_item:write']]
)]
class InventoryStockItem extends BaseEntity
{
    #[Groups(['inventory_stock_item:read', 'inventory_stock_item:write'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductInformation $productInformation = null;

    #[Groups(['inventory_stock_item:read', 'inventory_stock_item:write'])]
    #[ORM\ManyToOne]
    private ?InventoryItemCategory $category = null;

    /** How many units are currently in stock */
    #[Groups(['inventory_stock_item:read', 'inventory_stock_item:write'])]
    #[ORM\Column]
    private int $currentQuantity = 0;

    /** Below this quantity a restocking alert should be triggered */
    #[Groups(['inventory_stock_item:read', 'inventory_stock_item:write'])]
    #[ORM\Column]
    private int $minQuantity = 1;

    /** e.g. "pieces", "ml", "g", "l" */
    #[Groups(['inventory_stock_item:read', 'inventory_stock_item:write'])]
    #[ORM\Column(length: 50)]
    private string $unit = 'pieces';

    /** The source this item is usually restocked from */
    #[Groups(['inventory_stock_item:read', 'inventory_stock_item:write'])]
    #[ORM\ManyToOne(inversedBy: 'stockItems')]
    private ?SupplySource $preferredSupplySource = null;

    public function __construct()
    {
        parent::__construct();
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

    public function getCategory(): ?InventoryItemCategory
    {
        return $this->category;
    }

    public function setCategory(?InventoryItemCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCurrentQuantity(): int
    {
        return $this->currentQuantity;
    }

    public function setCurrentQuantity(int $currentQuantity): static
    {
        $this->currentQuantity = $currentQuantity;

        return $this;
    }

    public function getMinQuantity(): int
    {
        return $this->minQuantity;
    }

    public function setMinQuantity(int $minQuantity): static
    {
        $this->minQuantity = $minQuantity;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getPreferredSupplySource(): ?SupplySource
    {
        return $this->preferredSupplySource;
    }

    public function setPreferredSupplySource(?SupplySource $preferredSupplySource): static
    {
        $this->preferredSupplySource = $preferredSupplySource;

        return $this;
    }

    public function isLowStock(): bool
    {
        return $this->currentQuantity <= $this->minQuantity;
    }
}
