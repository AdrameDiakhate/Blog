<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Comments;
use App\Controller\Admin\PostCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(PostCrudController::class)->generateUrl());
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Myblog');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Post', 'fas fa-list', Post::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Comments::class);
    }
}