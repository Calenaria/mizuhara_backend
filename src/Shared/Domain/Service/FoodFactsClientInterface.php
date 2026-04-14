<?php

namespace App\Shared\Domain\Service;

interface FoodFactsClientInterface
{
    public function getProductByEan(string $ean): ?OpenFoodFactsProductDTO;
}
