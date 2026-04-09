<?php

namespace App\Inventory\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['supply_source:read', 'online_shop:read']],
    denormalizationContext: ['groups' => ['supply_source:write', 'online_shop:write']]
)]
class OnlineShop extends SupplySource
{
    #[Groups(['supply_source:read', 'online_shop:read', 'online_shop:write', 'product_supply_source:read'])]
    #[ORM\Column(length: 500)]
    private string $websiteUrl;

    #[Groups(['supply_source:read', 'online_shop:read', 'online_shop:write'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $logoUrl = null;

    public function getWebsiteUrl(): string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(string $websiteUrl): static
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(?string $logoUrl): static
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }
}
