<?php

namespace App\Shared\Infrastructure\Controller\Admin;

use App\Shared\Domain\Entity\AppConfiguration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AppConfigurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AppConfiguration::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('key'),
            TextField::new('value'),
            ChoiceField::new('type')
                ->setChoices([
                    'string' => 'string',
                    'boolean' => 'boolean',
                    'integer' => 'integer',
                    'float' => 'float',
                ]),
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
        ];
    }
}
