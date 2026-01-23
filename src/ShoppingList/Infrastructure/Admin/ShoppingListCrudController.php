<?php

namespace App\ShoppingList\Infrastructure\Admin;

use App\ShoppingList\Domain\Entity\ShoppingList;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShoppingListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShoppingList::class;
    }

    // Configure fields as needed
}
