<?php

namespace App\Shared\Infrastructure\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\ShoppingList\Domain\Entity\ShoppingList;
use App\ShoppingList\Domain\Entity\ShoppingListEntry;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Household Manager');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Family Calendar');

        yield MenuItem::section('Shopping');
        yield MenuItem::linkToCrud('Shopping Lists', 'fas fa-list', ShoppingList::class);
        yield MenuItem::linkToCrud('List Items', 'fas fa-shopping-cart', ShoppingListEntry::class);
    }
}
