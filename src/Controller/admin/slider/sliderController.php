<?php
/**
 * Created by PhpStorm.
 * Project: centrumodnowybiologicznej
 * User: Patryk Szczepański
 * Date: 22/09/2021
 * Time: 13:58
 */

namespace App\Controller\admin\slider;


use App\Entity\Slider;
use App\Form\SliderForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class sliderController extends AbstractController
{
    /**
     * Get common of admin
     * @Route("/adminpanel/slider", name="adminSlider")
     */
    public function promotionsAll(Request $request)
    {
        // create new entity and get manager for flushing it
        $slider = new Slider();
        $entityManager = $this->getDoctrine()->getManager();

        // create and handle adding form
        $form_add = $this->createForm(SliderForm::class, $slider);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            // flush new promo
            $entityManager->persist($slider);
            $entityManager->flush();

            $this->addFlash('add_success', 'Nowy slajd został dodany!');

            return $this->redirectToRoute('adminSlider');
        }

        return $this->render('admin/pages/slider/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Ustawienia slidera',
            'breadcrumbs' => [
                ['Panel Administracyjny', '#'],
                ['Slider', $this->generateUrl('adminSlider')]
            ],
            'slides' => $this->getDoctrine()->getRepository(Slider::class)->findAll(),
            'form_add' => $form_add->createView()
        ]);
    }

    /**
     * @Route("/adminpanel/slider/{id}/delete", name="adminSliderDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteSlider(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $slider = $this->getDoctrine()->getRepository(Slider::class)->find($id);

            if($slider !== NULL)
            {
                // finally, delete the OFFER
                $entityManager->remove($slider);
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
