<?php


namespace App\Controller\admin\dashboard;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for admin dashboard.
 *
 * Class dashboardController
 * @package App\Controller\admin
 */
class dashboardController extends AbstractController
{
    /**
     * Get common of admin
     * @Route("/adminpanel", name="adminDashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/pages/dashboard/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Panel Kontrolny',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Panel Kontrolny', '#']
            ]
        ]);
    }
}
