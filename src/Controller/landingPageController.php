<?php
/**
 * Created by PhpStorm.
 * Project: Centrum Odnowy Biologicznej
 * User: Patryk Szczepański
 * Date: 15/07/2021
 * Time: 19:00
 */

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class landingPageController extends AbstractController
{

    /**
     * Get common of home page
     *
     * @Route("/", name="homePage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function homePage()
    {
        return $this->render('landingPage/pages/homepage/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Landing Page ~ ',
            'breadcrumbs' => []
        ]);
    }

    /**
     * @Route("/o-nas/", name="aboutUsPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function aboutUsPage()
    {
        return $this->render('landingPage/pages/about-us/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'O Nas',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['O Nas', $this->generateUrl('aboutUsPage')]
            ]
        ]);
    }

    /**
     * @Route("/oferta/", name="offerPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function offerPage()
    {
        return $this->render('landingPage/pages/offer/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Oferta',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Oferta', $this->generateUrl('offerPage')]
            ],
            'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll()
        ]);
    }

    /**
     * @Route("/oferta/twarz", name="offerDetailsPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function offerDetails()
    {
        return $this->render('landingPage/pages/offer/services/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Zabiegi na twarz',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Oferta', $this->generateUrl('offerPage')],
                ['Zabiegi na twarz', $this->generateUrl('offerDetailsPage')]
            ]
        ]);
    }

    /**
     * @Route("/cennik/", name="pricesPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function pricesPage()
    {
        return $this->render('landingPage/pages/prices/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Cennik',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Cennik', $this->generateUrl('pricesPage')]
            ]
        ]);
    }

    /**
     * @Route("/promocje/", name="promotionsPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function promotionsPage()
    {
        return $this->render('landingPage/pages/promotions/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Promocje',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Promocje', $this->generateUrl('promotionsPage')]
            ]
        ]);
    }

    /**
     * @Route("/kontakt/", name="contactPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function contactPage()
    {
        return $this->render('landingPage/pages/contact/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Kontakt',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Kontakt', $this->generateUrl('contactPage')]
            ]
        ]);
    }
}
