<?php

namespace App\Inventory\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['supply_source:read', 'physical_store:read']],
    denormalizationContext: ['groups' => ['supply_source:write', 'physical_store:write']]
)]
class PhysicalStore extends SupplySource
{
    #[Groups(['supply_source:read', 'physical_store:read', 'physical_store:write'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $address = null;

    #[Groups(['supply_source:read', 'physical_store:read', 'physical_store:write', 'product_supply_source:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Groups(['supply_source:read', 'physical_store:read', 'physical_store:write'])]
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $postalCode = null;

    #[Groups(['supply_source:read', 'physical_store:read', 'physical_store:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[Groups(['supply_source:read', 'physical_store:read', 'physical_store:write'])]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $openingHours = null;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->openingHours;
    }

    public function setOpeningHours(?string $openingHours): static
    {
        $this->openingHours = $openingHours;

        return $this;
    }
}
