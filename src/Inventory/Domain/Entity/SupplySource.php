<?php

namespace App\Inventory\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Inventory\Domain\Repository\SupplySourceRepository;
use App\Shared\Domain\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SupplySourceRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'online_shop' => OnlineShop::class,
    'physical_store' => PhysicalStore::class,
])]
#[ApiResource(
    normalizationContext: ['groups' => ['supply_source:read']],
    denormalizationContext: ['groups' => ['supply_source:write']]
)]
abstract class SupplySource extends BaseEntity
{
    #[Groups(['supply_source:read', 'supply_source:write', 'inventory_stock_item:read', 'product_supply_source:read'])]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Groups(['supply_source:read', 'supply_source:write'])]
    #[ORM\Column(nullable: true, type: 'text')]
    private ?string $notes = null;

    #[Groups(['supply_source:read', 'supply_source:write'])]
    #[ORM\Column]
    private bool $isActive = true;

    #[ORM\OneToMany(targetEntity: ProductSupplySource::class, mappedBy: 'supplySource', orphanRemoval: true)]
    private Collection $productSupplySources;

    #[ORM\OneToMany(targetEntity: InventoryStockItem::class, mappedBy: 'preferredSupplySource')]
    private Collection $stockItems;

    public function __construct()
    {
        $this->productSupplySources = new ArrayCollection();
        $this->stockItems = new ArrayCollection();
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getProductSupplySources(): Collection
    {
        return $this->productSupplySources;
    }

    public function addProductSupplySource(ProductSupplySource $productSupplySource): static
    {
        if (!$this->productSupplySources->contains($productSupplySource)) {
            $this->productSupplySources->add($productSupplySource);
            $productSupplySource->setSupplySource($this);
        }

        return $this;
    }

    public function removeProductSupplySource(ProductSupplySource $productSupplySource): static
    {
        if ($this->productSupplySources->removeElement($productSupplySource)) {
            if ($productSupplySource->getSupplySource() === $this) {
                $productSupplySource->setSupplySource(null);
            }
        }

        return $this;
    }

    public function getStockItems(): Collection
    {
        return $this->stockItems;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
