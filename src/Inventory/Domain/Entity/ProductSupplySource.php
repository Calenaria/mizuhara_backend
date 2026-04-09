<?php

namespace App\Inventory\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Inventory\Domain\Repository\ProductSupplySourceRepository;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\ProductInformation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * Links a ProductInformation to a SupplySource, optionally storing
 * price and a direct product URL for that specific source.
 */
#[ORM\Entity(repositoryClass: ProductSupplySourceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['product_supply_source:read']],
    denormalizationContext: ['groups' => ['product_supply_source:write']]
)]
class ProductSupplySource extends BaseEntity
{
    #[Groups(['product_supply_source:read', 'product_supply_source:write'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductInformation $productInformation = null;

    #[Groups(['product_supply_source:read', 'product_supply_source:write'])]
    #[ORM\ManyToOne(inversedBy: 'productSupplySources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SupplySource $supplySource = null;

    /** Approximate or last-known price at this source */
    #[Groups(['product_supply_source:read', 'product_supply_source:write'])]
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    /** Direct link to the product page on this source */
    #[Groups(['product_supply_source:read', 'product_supply_source:write'])]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $productUrl = null;

    #[Groups(['product_supply_source:read', 'product_supply_source:write'])]
    #[ORM\Column]
    private bool $isPreferred = false;

    #[Groups(['product_supply_source:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastCheckedAt = null;

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

    public function getSupplySource(): ?SupplySource
    {
        return $this->supplySource;
    }

    public function setSupplySource(?SupplySource $supplySource): static
    {
        $this->supplySource = $supplySource;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getProductUrl(): ?string
    {
        return $this->productUrl;
    }

    public function setProductUrl(?string $productUrl): static
    {
        $this->productUrl = $productUrl;

        return $this;
    }

    public function isPreferred(): bool
    {
        return $this->isPreferred;
    }

    public function setIsPreferred(bool $isPreferred): static
    {
        $this->isPreferred = $isPreferred;

        return $this;
    }

    public function getLastCheckedAt(): ?\DateTimeImmutable
    {
        return $this->lastCheckedAt;
    }

    public function setLastCheckedAt(?\DateTimeImmutable $lastCheckedAt): static
    {
        $this->lastCheckedAt = $lastCheckedAt;

        return $this;
    }
}
