<?php


namespace App\Controller\admin\promotions;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for admin dashboard.
 *
 * Class promotionsController
 * @package App\Controller\admin\promotions
 */
class promotionsController extends AbstractController
{
    /**
     * Get common of admin
     * @Route("/adminpanel/promotions", name="adminPromotionsAll")
     */
    public function promotionsAll()
    {
        return $this->render('admin/pages/promotions/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Promocje na stronie',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Promocje na stronie', $this->generateUrl('adminPromotionsAll')]
            ]
        ]);
    }
    /**
     * Get common of admin
     * @Route("/adminpanel/promotions/featured", name="adminPromotionsFeatured")
     */
    public function promotionsFeatured()
    {
        return $this->render('admin/pages/promotions/featured/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Wyróżnione promocje',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Wyóżnione promocje', $this->generateUrl('adminPromotionsFeatured')]
            ]
        ]);
    }
}
