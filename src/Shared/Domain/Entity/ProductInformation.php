<?php

namespace App\Shared\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Shared\Domain\Repository\ProductInformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductInformationRepository::class)]
#[ApiResource]
class ProductInformation extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $genericName = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'productInformation')]
    #[ORM\JoinColumn(nullable: true)]
    private ?ProductBrand $brand = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $brandOwner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $productQuantity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $packaging = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $categories = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $categoriesTags = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mainCategory = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $foodGroups = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pnnsGroups1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pnnsGroups2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ingredientsText = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ingredientsTags = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ingredientsAnalysisTags = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $labels = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $labelsTags = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $allergens = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $energyKcal100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $proteins100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $fat100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $carbohydrates100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $fiber100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6, nullable: true)]
    private ?string $vitaminB12100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6, nullable: true)]
    private ?string $iron100g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6, nullable: true)]
    private ?string $calcium100g = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $stores = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $purchasePlaces = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $countries = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $environmentalScoreScore = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $environmentalScoreGrade = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageUrl = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): static
    {
        $this->productName = $productName;
        return $this;
    }

    public function getGenericName(): ?string
    {
        return $this->genericName;
    }

    public function setGenericName(?string $genericName): static
    {
        $this->genericName = $genericName;
        return $this;
    }

    public function getBrand(): ?ProductBrand
    {
        return $this->brand;
    }

    public function setBrand(?ProductBrand $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    public function getBrandOwner(): ?string
    {
        return $this->brandOwner;
    }

    public function setBrandOwner(?string $brandOwner): static
    {
        $this->brandOwner = $brandOwner;
        return $this;
    }

    // Add all other getters/setters...
    public function getQuantity(): ?string { return $this->quantity; }
    public function setQuantity(?string $quantity): static { $this->quantity = $quantity; return $this; }

    public function getProductQuantity(): ?string { return $this->productQuantity; }
    public function setProductQuantity(?string $productQuantity): static { $this->productQuantity = $productQuantity; return $this; }

    public function getPackaging(): ?string { return $this->packaging; }
    public function setPackaging(?string $packaging): static { $this->packaging = $packaging; return $this; }

    public function getCategories(): ?string { return $this->categories; }
    public function setCategories(?string $categories): static { $this->categories = $categories; return $this; }

    public function getCategoriesTags(): ?string { return $this->categoriesTags; }
    public function setCategoriesTags(?string $categoriesTags): static { $this->categoriesTags = $categoriesTags; return $this; }

    public function getMainCategory(): ?string { return $this->mainCategory; }
    public function setMainCategory(?string $mainCategory): static { $this->mainCategory = $mainCategory; return $this; }

    public function getFoodGroups(): ?string { return $this->foodGroups; }
    public function setFoodGroups(?string $foodGroups): static { $this->foodGroups = $foodGroups; return $this; }

    public function getPnnsGroups1(): ?string { return $this->pnnsGroups1; }
    public function setPnnsGroups1(?string $pnnsGroups1): static { $this->pnnsGroups1 = $pnnsGroups1; return $this; }

    public function getPnnsGroups2(): ?string { return $this->pnnsGroups2; }
    public function setPnnsGroups2(?string $pnnsGroups2): static { $this->pnnsGroups2 = $pnnsGroups2; return $this; }

    public function getIngredientsText(): ?string { return $this->ingredientsText; }
    public function setIngredientsText(?string $ingredientsText): static { $this->ingredientsText = $ingredientsText; return $this; }

    public function getIngredientsTags(): ?string { return $this->ingredientsTags; }
    public function setIngredientsTags(?string $ingredientsTags): static { $this->ingredientsTags = $ingredientsTags; return $this; }

    public function getIngredientsAnalysisTags(): ?string { return $this->ingredientsAnalysisTags; }
    public function setIngredientsAnalysisTags(?string $ingredientsAnalysisTags): static { $this->ingredientsAnalysisTags = $ingredientsAnalysisTags; return $this; }

    public function getLabels(): ?string { return $this->labels; }
    public function setLabels(?string $labels): static { $this->labels = $labels; return $this; }

    public function getLabelsTags(): ?string { return $this->labelsTags; }
    public function setLabelsTags(?string $labelsTags): static { $this->labelsTags = $labelsTags; return $this; }

    public function getAllergens(): ?string { return $this->allergens; }
    public function setAllergens(?string $allergens): static { $this->allergens = $allergens; return $this; }

    public function getEnergyKcal100g(): ?string { return $this->energyKcal100g; }
    public function setEnergyKcal100g(?string $energyKcal100g): static { $this->energyKcal100g = $energyKcal100g; return $this; }

    public function getProteins100g(): ?string { return $this->proteins100g; }
    public function setProteins100g(?string $proteins100g): static { $this->proteins100g = $proteins100g; return $this; }

    public function getFat100g(): ?string { return $this->fat100g; }
    public function setFat100g(?string $fat100g): static { $this->fat100g = $fat100g; return $this; }

    public function getCarbohydrates100g(): ?string { return $this->carbohydrates100g; }
    public function setCarbohydrates100g(?string $carbohydrates100g): static { $this->carbohydrates100g = $carbohydrates100g; return $this; }

    public function getFiber100g(): ?string { return $this->fiber100g; }
    public function setFiber100g(?string $fiber100g): static { $this->fiber100g = $fiber100g; return $this; }

    public function getVitaminB12100g(): ?string { return $this->vitaminB12100g; }
    public function setVitaminB12100g(?string $vitaminB12100g): static { $this->vitaminB12100g = $vitaminB12100g; return $this; }

    public function getIron100g(): ?string { return $this->iron100g; }
    public function setIron100g(?string $iron100g): static { $this->iron100g = $iron100g; return $this; }

    public function getCalcium100g(): ?string { return $this->calcium100g; }
    public function setCalcium100g(?string $calcium100g): static { $this->calcium100g = $calcium100g; return $this; }

    public function getStores(): ?string { return $this->stores; }
    public function setStores(?string $stores): static { $this->stores = $stores; return $this; }

    public function getPurchasePlaces(): ?string { return $this->purchasePlaces; }
    public function setPurchasePlaces(?string $purchasePlaces): static { $this->purchasePlaces = $purchasePlaces; return $this; }

    public function getCountries(): ?string { return $this->countries; }
    public function setCountries(?string $countries): static { $this->countries = $countries; return $this; }

    public function getEnvironmentalScoreScore(): ?int { return $this->environmentalScoreScore; }
    public function setEnvironmentalScoreScore(?int $environmentalScoreScore): static { $this->environmentalScoreScore = $environmentalScoreScore; return $this; }

    public function getEnvironmentalScoreGrade(): ?string { return $this->environmentalScoreGrade; }
    public function setEnvironmentalScoreGrade(?string $environmentalScoreGrade): static { $this->environmentalScoreGrade = $environmentalScoreGrade; return $this; }

    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(?string $imageUrl): static { $this->imageUrl = $imageUrl; return $this; }
}
