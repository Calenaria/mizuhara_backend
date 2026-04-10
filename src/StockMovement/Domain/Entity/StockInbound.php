<?php

namespace App\StockMovement\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Shared\Domain\Entity\BaseEntity;
use App\Shared\Domain\Entity\ProductInformation;
use App\StockMovement\Application\Processor\StockInboundProcessor;
use App\StockMovement\Domain\Repository\StockInboundRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockInboundRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
        new Post(
            uriTemplate: '/stock_in',
            normalizationContext: ['groups' => ['stock_inbound:read']],
            deserialize: false,
            processor: StockInboundProcessor::class,
        ),
    ],
)]
class StockInbound extends BaseEntity
{
    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    #[ORM\ManyToOne(inversedBy: 'stockInbounds')]
    private ?ProductInformation $product = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $freeTextProductName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getProduct(): ?ProductInformation
    {
        return $this->product;
    }

    public function setProduct(?ProductInformation $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getFreeTextProductName(): ?string
    {
        return $this->freeTextProductName;
    }

    public function setFreeTextProductName(?string $freeTextProductName): static
    {
        $this->freeTextProductName = $freeTextProductName;

        return $this;
    }
}
