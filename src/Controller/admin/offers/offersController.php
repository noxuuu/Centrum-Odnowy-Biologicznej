<?php


namespace App\Controller\admin\offers;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for admin dashboard.
 *
 * Class offersController
 * @package App\Controller\admin\offers
 */
class offersController extends AbstractController
{
    /**
     * Get common of admin
     * @Route("/adminpanel/offers", name="adminOffers")
     */
    public function categories()
    {
        return $this->render('admin/pages/offers/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Oferta',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Oferta', $this->generateUrl('adminOffers')]
            ]
        ]);
    }
}
