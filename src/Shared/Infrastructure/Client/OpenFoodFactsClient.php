<?php

namespace App\Shared\Infrastructure\Client;

use App\Shared\Domain\Service\FoodFactsClientInterface;
use App\Shared\Domain\Service\OpenFoodFactsProductDTO;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenFoodFactsClient implements FoodFactsClientInterface
{
    private const string BASE_URL = 'https://world.openfoodfacts.org/api/v2/product/';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {}

    public function getProductByEan(string $ean): ?OpenFoodFactsProductDTO
    {
        $response = $this->httpClient->request('GET', self::BASE_URL . $ean . '.json');

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $data = $response->toArray();

        if (($data['status'] ?? 0) !== 1) {
            return null;
        }

        $product = $data['product'];
        $nutriments = $product['nutriments'] ?? [];

        return new OpenFoodFactsProductDTO(
            ean: $ean,
            productName: $product['product_name'] ?? null,
            genericName: $product['generic_name'] ?? null,
            brands: $product['brands'] ?? null,
            quantity: $product['quantity'] ?? null,
            ingredientsText: $product['ingredients_text'] ?? null,
            allergens: $product['allergens'] ?? null,
            imageUrl: $product['image_url'] ?? null,
            labels: $product['labels'] ?? null,
            novaGroup: isset($product['nova_group']) ? (int) $product['nova_group'] : null,
            nutriscoreGrade: $product['nutriscore_grade'] ?? null,
            ecoscoreGrade: $product['ecoscore_grade'] ?? null,
            energyKcal100g: isset($nutriments['energy-kcal_100g']) ? (float) $nutriments['energy-kcal_100g'] : null,
            proteins100g: isset($nutriments['proteins_100g']) ? (float) $nutriments['proteins_100g'] : null,
            fat100g: isset($nutriments['fat_100g']) ? (float) $nutriments['fat_100g'] : null,
            carbohydrates100g: isset($nutriments['carbohydrates_100g']) ? (float) $nutriments['carbohydrates_100g'] : null,
            addedSugars100g: isset($nutriments['added-sugars_100g']) ? (float) $nutriments['added-sugars_100g'] : null,
        );
    }
}
