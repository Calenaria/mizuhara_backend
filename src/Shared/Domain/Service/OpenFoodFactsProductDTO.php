<?php

namespace App\Shared\Domain\Service;

class OpenFoodFactsProductDTO
{
    public function __construct(
        public readonly string $ean,
        public readonly ?string $productName,
        public readonly ?string $genericName,
        public readonly ?string $brands,
        public readonly ?string $quantity,
        public readonly ?string $ingredientsText,
        public readonly ?string $allergens,
        public readonly ?string $imageUrl,
        public readonly ?string $labels,
        public readonly ?int $novaGroup,
        public readonly ?string $nutriscoreGrade,
        public readonly ?string $ecoscoreGrade,
        public readonly ?float $energyKcal100g,
        public readonly ?float $proteins100g,
        public readonly ?float $fat100g,
        public readonly ?float $carbohydrates100g,
        public readonly ?float $addedSugars100g,
    ) {}
}
