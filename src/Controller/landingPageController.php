<?php
/**
 * Created by PhpStorm.
 * Project: Centrum Odnowy Biologicznej
 * User: Patryk Szczepański
 * Date: 15/07/2021
 * Time: 19:00
 */

namespace App\Controller;

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
     * @Route("/promocje/", name="promotionsPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function promotionsPage()
    {
        return $this->render('landingPage/pages/promotions/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Promocje',
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
