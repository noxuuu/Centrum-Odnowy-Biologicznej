<?php


namespace App\Controller\admin\offers;


use App\Entity\Category;
use App\Entity\Offer;
use App\Entity\OfferCombination;
use App\Form\CategoryType;
use App\Form\OfferCombinationType;
use App\Form\OfferType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
     * @Route("/adminpanel/offers/create", name="adminOffersAdd")
     */
    public function addOffer()
    {
        // create and handle form
        $form_add = $this->createForm(OfferType::class, new Offer());

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
     * Create new offer POST
     * @Route("/adminpanel/offers/add", name="ajaxOfferPost", methods="POST")
     * @return JsonResponse
     * @throws \Exception
     */
    public function addOfferAjax(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $entityManager = $this->getDoctrine()->getManager();

            try {
                $offer = new Offer();
                $offer->setName($request->request->get('name'));
                $offer->setEffects($request->request->get('effects'));
                $offer->setCategory($this->getDoctrine()->getRepository(Category::class)->find($request->request->get('category')));
                $offer->setAftercare($request->request->get('aftercare'));
                $offer->setDescribtion($request->request->get('description'));
                $offer->setContraindications($request->request->get('contraindications'));

                $entityManager->persist($offer);
                $entityManager->flush();

            } catch (\Exception $exception) {
                return new JsonResponse(false);
            }
            return new JsonResponse(true);
        }
        else
            throw new \Exception('Not allowed usage');
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

    /**
     * Get common of admin
     * @Route("/adminpanel/offers/{offer}/combinations", name="adminOfferCombinations")
     * @Entity("offer", expr="repository.find(offer)")
     */
    public function offerCombinations(Request $request, Offer $offer)
    {
        //get manager
        $entityManager = $this->getDoctrine()->getManager();

        // create new combination and set it's entity to valid.
        $offerCombination = new OfferCombination();
        $offerCombination->setOffer($offer);
        $offerCombination->setType(0);

        // create form and handle form
        $form_add = $this->createForm(OfferCombinationType::class, $offerCombination);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            $entityManager->persist($offerCombination);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano kombinacje do istniejącej oferty!');

            return $this->redirectToRoute('adminOfferCombinations', ['offer'=>$offer->getId()]);
        }

        // return view
        return $this->render('admin/pages/offers/combinations/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Kombinacje oferty',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Oferta', $this->generateUrl('adminOffers')],
                [$offer->getName(), "#"],
                ['Kombinacje', $this->generateUrl('adminOfferCombinations', ['offer' => $offer->getId()])]
            ],
            'offer' => $offer,
            'combinations' => $offer->getOfferCombinations(),
            'form_add' => $form_add->createView()
        ]);
    }


    /**
     * @Route("/adminpanel/offer/combinations/{id}/delete", name="adminOfferCombinationDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteOfferCombination(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $combination = $this->getDoctrine()->getRepository(OfferCombination::class)->find($id);

            if($combination !== NULL)
            {
                // finally, delete the OFFER
                $entityManager->remove($combination);
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
