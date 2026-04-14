<?php

namespace App\Tests\Functional\StockMovement;

use App\Shared\Domain\Service\FoodFactsClientInterface;
use App\Shared\Domain\Service\OpenFoodFactsProductDTO;
use App\StockMovement\Domain\Entity\StockInbound;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;

#[ResetDatabase]
class StockInboundTest extends WebTestCase
{
    public function testStockingInboundThroughApiEndpoint(): void {
        $client = static::createClient();

        $ean = '5000112672466';

        $mockDto = new OpenFoodFactsProductDTO(
            ean: $ean,
            productName: 'Coca Cola Zero Sugar',
            genericName: 'Cola',
            brands: 'The Coca Cola Company',
            quantity: '1pcs',
            ingredientsText: null,
            allergens: null,
            imageUrl: null,
            labels: null,
            novaGroup: 4,
            nutriscoreGrade: 'unknown',
            ecoscoreGrade: 'unknown',
            energyKcal100g: 0.2,
            proteins100g: 0.0,
            fat100g: 0.0,
            carbohydrates100g: 0.0,
            addedSugars100g: 0.0,
        );

        $mockClient = $this->createMock(FoodFactsClientInterface::class);
        $mockClient->method('getProductByEan')->with($ean)->willReturn($mockDto);

        static::getContainer()->set(FoodFactsClientInterface::class, $mockClient);

        $client->request(
            method: 'POST',
            uri: '/api/stock_in',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(['ean' => $ean, 'amount' => 1.5, 'unit' => 'kg']),
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $em = static::getContainer()->get('doctrine')->getManager();
        $entity = $em->getRepository(StockInbound::class)->findOneBy(['unit' => 'kg']);

        $this->assertNotNull($entity);
        $this->assertEquals(1.5, $entity->getAmount());
        $this->assertNotNull($entity->getProduct());
        $this->assertEquals($ean, $entity->getProduct()->getCode());
    }
}
