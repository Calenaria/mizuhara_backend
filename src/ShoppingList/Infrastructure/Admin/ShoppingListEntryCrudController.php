<?php

namespace App\ShoppingList\Infrastructure\Admin;

use App\ShoppingList\Domain\Entity\ShoppingList;
use App\ShoppingList\Domain\Entity\ShoppingListEntry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShoppingListEntryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShoppingListEntry::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('shoppingList'),
            AssociationField::new('productInformation'),
            AssociationField::new('addedBy'),
        ];
    }
}
