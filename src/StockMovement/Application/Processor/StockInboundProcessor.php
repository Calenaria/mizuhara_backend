<?php

namespace App\StockMovement\Application\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Shared\Application\Service\ProductResolver;
use App\StockMovement\Domain\Entity\StockInbound;
use App\StockMovement\Infrastructure\Persister\StockInboundPersister;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

readonly class StockInboundProcessor implements ProcessorInterface
{
    public function __construct(
        private ProductResolver       $productResolver,
        private StockInboundPersister $persister,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var Request $request */
        $request = $context['request'];
        $payload = json_decode($request->getContent(), true);

        $ean = $payload['ean'] ?? null;
        $amount = $payload['amount'] ?? null;
        $unit = $payload['unit'] ?? null;

        if ($ean === null || $amount === null || $unit === null) {
            throw new BadRequestHttpException('Fields "ean", "amount" and "unit" are required.');
        }

        $product = $this->productResolver->resolveByEan($ean);

        if ($product === null) {
            throw new UnprocessableEntityHttpException(sprintf('Product with EAN "%s" could not be found.', $ean));
        }

        $stockInbound = new StockInbound();
        $stockInbound->setAmount((float) $amount);
        $stockInbound->setUnit($unit);
        $stockInbound->setProduct($product);

        $this->persister->persist($stockInbound);

        return $stockInbound;
    }
}
