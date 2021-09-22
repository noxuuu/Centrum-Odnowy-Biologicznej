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
use App\Entity\FeaturedPromotion;
use App\Entity\Offer;
use App\Entity\Promotion;
use App\Entity\Slider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        // get repo
        $promotions = Array();
        $featuredPromotionsRepo = $this->getDoctrine()->getRepository(FeaturedPromotion::class);

        // get promos and assign it to offer names
        $offers = $featuredPromotionsRepo->getOffersFromFeaturedPromotions(3);
        foreach ($offers as $offer)
            $promotions[$offer['name']] = $featuredPromotionsRepo->getOfferCombinationsFromFeaturedPromotions($offer['name']);

        return $this->render('landingPage/pages/homepage/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Strona główna ~ ',
            'breadcrumbs' => [],
            'promotions' => $promotions,
            'slides' => $this->getDoctrine()->getRepository(Slider::class)->findAll()

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
    public function offerPage(Request $request)
    {
        // categories
        $categories = array();
        $categoriesRepo = $this->getDoctrine()->getRepository(Category::class);

        // breadcrumbs
        $breadcrumbs = [
            ['Strona glowna', $this->generateUrl('homePage')],
            ['Oferta', $this->generateUrl('offerPage')]
        ];

        // get selected category
        $selectedCategory = $request->query->get('category');
        if($selectedCategory !== null) {
            $selectedCategory = $categoriesRepo->find($selectedCategory);
            $categories = $selectedCategory->getSubCategories();

            // add breadcrumb
            array_push($breadcrumbs, [
                $selectedCategory->getName(),
                $this->generateUrl('offerPage', ['category' => $selectedCategory->getId()])
            ]);
        } else {
            $selectedCategory = null;
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        }

        return $this->render('landingPage/pages/offer/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Oferta',
            'breadcrumbs' => $breadcrumbs,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/oferta/{category}/{offer}", name="offerDetailsPage")
     * @param $category
     * @param $offer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function offerDetails($category, $offer)
    {
        // get repo's
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);
        $offersRepo = $this->getDoctrine()->getRepository(Offer::class);

        // get valid data from route params
        $category = $categoryRepo->findOneBy(['name' => $category]);
        $offer = $offersRepo->findOneBy(['name' => $offer]);

        // when something is wrong with provided data - call exception
        if($category == null || $offer == null)
            throw new NotFoundHttpException('Nie znaleziono takiej oferty');


        // return view
        return $this->render('landingPage/pages/offer/services/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => $category->getName(),
            'categories' => $categoryRepo->findAll(),
            'category' => $category,
            'offer' => $offer,
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Oferta', $this->generateUrl('offerPage')],
                [$category->getName(), $this->generateUrl('offerDetailsPage', ['category' => $category->getName(), 'offer' => $offer->getName()])]
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
        // get repo's
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class);
        $offersRepo = $this->getDoctrine()->getRepository(Offer::class);

        return $this->render('landingPage/pages/prices/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Cennik',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Cennik', $this->generateUrl('pricesPage')]
            ],
            'categories' => $categoryRepo->findAll(),
            'offers' => $offersRepo->findAll(),
        ]);
    }

    /**
     * @Route("/promocje/", name="promotionsPage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function promotionsPage()
    {
        // get repo
        $promotions = Array();
        $promotionsRepo = $this->getDoctrine()->getRepository(Promotion::class);

        // get promos and assign it to offer names
        $offers = $promotionsRepo->getOffersFromPromotions(12);
        foreach ($offers as $offer)
            $promotions[$offer['name']] = $promotionsRepo->getOfferCombinationsFromPromotions($offer['name']);


        return $this->render('landingPage/pages/promotions/index.html.twig', [
            'mainTitle' => 'Centrum Odnowy Biologicznej w Cycowie',
            'pageTitle' => 'Promocje',
            'breadcrumbs' => [
                ['Strona glowna', $this->generateUrl('homePage')],
                ['Promocje', $this->generateUrl('promotionsPage')]
            ],
            'promotions' => $promotions
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
