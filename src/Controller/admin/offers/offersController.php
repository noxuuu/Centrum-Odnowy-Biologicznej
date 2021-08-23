<?php


namespace App\Controller\admin\offers;


use App\Entity\Offer;
use App\Form\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function offers(Request $request)
    {
        // get repos
        $offersRepo = $this->getDoctrine()->getRepository(Offer::class);

        // create and handle form
        $offer = new Offer();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(OfferType::class, $offer);
        $form_edit = $this->createForm(OfferType::class, $offer);

        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            $entityManager->persist($offer);
            $entityManager->flush();

            $this->addFlash('add_success', 'Utworzono oferte '.$offer->getName().'!');

            return $this->redirectToRoute('adminOffers');
        }

        // return view
        return $this->render('admin/pages/offers/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Oferta',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Oferta', $this->generateUrl('adminOffers')]
            ],
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit,
            'offers' => $offersRepo->findAll()
        ]);
    }
}
