<?php

namespace App\ShoppingList\Domain\Service;

use App\ShoppingList\Domain\Entity\ShoppingList;
use Doctrine\ORM\EntityManagerInterface;

class ShoppingListService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
}
