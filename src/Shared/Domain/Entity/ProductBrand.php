<?php

namespace App\Shared\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Shared\Domain\Repository\ProductBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductBrandRepository::class)]
#[ApiResource]
class ProductBrand
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ProductInformation>
     */
    #[ORM\OneToMany(targetEntity: ProductInformation::class, mappedBy: 'brand')]
    private Collection $productInformation;

    public function __construct()
    {
        $this->productInformation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, ProductInformation>
     */
    public function getProductInformation(): Collection
    {
        return $this->productInformation;
    }

    public function addProductInformation(ProductInformation $productInformation): static
    {
        if (!$this->productInformation->contains($productInformation)) {
            $this->productInformation->add($productInformation);
            $productInformation->setBrand($this);
        }

        return $this;
    }

    public function removeProductInformation(ProductInformation $productInformation): static
    {
        if ($this->productInformation->removeElement($productInformation)) {
            // set the owning side to null (unless already changed)
            if ($productInformation->getBrand() === $this) {
                $productInformation->setBrand(null);
            }
        }

        return $this;
    }
}
