<?php

namespace App\StockMovement\Infrastructure\Persister;

use App\StockMovement\Domain\Entity\StockInbound;
use Doctrine\ORM\EntityManagerInterface;

readonly class StockInboundPersister
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function persist(StockInbound $stockInbound): void
    {
        $this->entityManager->persist($stockInbound);
        $this->entityManager->flush();
    }
}
