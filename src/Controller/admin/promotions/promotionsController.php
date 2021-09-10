<?php


namespace App\Controller\admin\promotions;


use App\Entity\OfferCombination;
use App\Entity\Promotion;
use App\Form\PromotionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function promotionsAll(Request $request)
    {
        // get repos
        $promotionsRepo = $this->getDoctrine()->getRepository(Promotion::class);
        $offerCombinationsRepo = $this->getDoctrine()->getRepository(OfferCombination::class);

        // create new entity and get manager for flushing it
        $promotion = new Promotion();
        $entityManager = $this->getDoctrine()->getManager();

        // create and handle adding form
        $form_add = $this->createForm(PromotionType::class, $promotion);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            // make our offerCombination id be an object
            $formData = $form_add->getData();
            $combination = $offerCombinationsRepo->find($formData->getOfferCombination());
            $promotion->setOfferCombination($combination);

            // flush new promo
            $entityManager->persist($promotion);
            $entityManager->flush();

            $this->addFlash('add_success', 'Nowa promocja została dodana!');

            return $this->redirectToRoute('adminPromotionsAll');
        }

        return $this->render('admin/pages/promotions/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Promocje na stronie',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Promocje na stronie', $this->generateUrl('adminPromotionsAll')]
            ],
            'promotions' => $promotionsRepo->findAll(),
            'form_add' => $form_add->createView()
        ]);
    }


    /**
     * @Route("/adminpanel/offer/promotions/{id}/delete", name="adminPromotionDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deletePromotion(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $promotion = $this->getDoctrine()->getRepository(Promotion::class)->find($id);

            if($promotion !== NULL)
            {
                // finally, delete the OFFER
                $entityManager->remove($promotion);
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
     * @Route("/adminpanel/offers/promotions/featured", name="adminPromotionsFeatured")
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


    /**
     * @Route("/adminpanel/offer/promotions/featured/{id}/delete", name="adminFeaturedPromotionDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteFeaturedPromotion(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $promotion = $this->getDoctrine()->getRepository(Promotion::class)->find($id);

            if($promotion !== NULL) 
            {
                $entityManager->remove($promotion);
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
