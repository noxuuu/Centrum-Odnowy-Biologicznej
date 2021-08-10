<?php


namespace App\Controller\admin\categories;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for admin dashboard.
 *
 * Class categoriesController
 * @package App\Controller\admin\categories
 */
class categoriesController extends AbstractController
{
    /**
     * Get common of admin
     * @Route("/adminpanel/categories", name="adminCategories")
     */
    public function categories()
    {
        return $this->render('admin/pages/categories/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Kategorie ofert',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Kategorie ofert', $this->generateUrl('adminCategories')]
            ]
        ]);
    }
}
