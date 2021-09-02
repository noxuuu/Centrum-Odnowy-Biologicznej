<?php


namespace App\Controller\admin\offers;


use App\Entity\Offer;
use App\Form\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function offers()
    {
        // get repos
        $offersRepo = $this->getDoctrine()->getRepository(Offer::class);

        // create and handle form
        $offer = new Offer();
        $form_edit = $this->createForm(OfferType::class, $offer);

        // return view
        return $this->render('admin/pages/offers/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Oferta',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Oferta', $this->generateUrl('adminOffers')]
            ],
            'form_edit' => $form_edit,
            'offers' => $offersRepo->findAll()
        ]);
    }

    /**
     * Create new offer
     * @Route("/adminpanel/offers/add", name="adminOffersAdd")
     */
    public function addOffer(Request $request)
    {
        // create and handle form
        $offer = new Offer();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(OfferType::class, $offer);

        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            $entityManager->persist($offer);
            $entityManager->flush();

            $this->addFlash('add_success', 'Utworzono oferte '.$offer->getName().'!');

            return $this->redirectToRoute('adminOffers');
        }

        // return view
        return $this->render('admin/pages/offers/add/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Tworzenie nowej oferty',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Oferta', $this->generateUrl('adminOffers')],
                ['Tworzenie nowej oferty', $this->generateUrl('adminOffersAdd')]
            ],
            'form_add' => $form_add->createView()
        ]);
    }

    /**
     * @Route("/adminpanel/offers/{id}/delete", name="adminOfferDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteOffer(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $offer = $this->getDoctrine()->getRepository(Offer::class)->find($id);

            if($offer !== NULL)
            {
                // finally, delete the OFFER
                $entityManager->remove($offer);
                $entityManager->flush();

                $data[0] = true;
            }
            else
                $data[0] = false;

        } catch (\Exception $e) {
            $data[0] = false;
        }

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }
}
