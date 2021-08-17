<?php


namespace App\Controller\admin\categories;


use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for admin dashboard.
 *
 * Class categoriesController
 * @package App\Controller\admin\categories
 */
class categoriesController extends AbstractController
{
    /**
     * Get common of admin
     * @Route("/adminpanel/categories", name="adminCategories")
     */
    public function categories(Request $request)
    {
        // get repos
        $categoriesRepo = $this->getDoctrine()->getRepository(Category::class);

        // get selected category
        $selectedCategory = $request->query->get('category');
        if($selectedCategory !== null)
            $selectedCategory = $categoriesRepo->find($selectedCategory);
        else
            $selectedCategory = null;

        // get data
        $categories = $selectedCategory == null ? $categoriesRepo->findAll():$categoriesRepo->findBy(['parent' => $selectedCategory->getId()]);

        // create and handle form
        $category = new Category();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(CategoryType::class, $category);
        $form_edit = $this->createForm(CategoryType::class, $category);

        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('add_success', 'Utworzono kategorie '.$category->getName().'!');

            return $this->redirectToRoute('adminCategories');
        }

        // add some breadcrumbs
        $breadcrumbs = [
            ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
            ['Kategorie ofert', $this->generateUrl('adminCategories')]
        ];

        // Add to breadcrumbs
        if($selectedCategory !== null) {
            $currentParent = $selectedCategory;
            for($i = 0; $i <= count($categories); $i++) {
                if($currentParent->getParent() === null)
                    break;

                $parentOf = $currentParent->getParent();
                array_push($breadcrumbs, [$parentOf->getName(), $this->generateUrl("adminCategories", ['category' => $parentOf->getId()])]);
            }
            array_push($breadcrumbs, [$selectedCategory->getName(), $this->generateUrl("adminCategories", ['category' => $selectedCategory->getId()])]);
        }

        return $this->render('admin/pages/categories/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => $selectedCategory === null ? 'Kategorie ofert' : 'Podkategorie oferty '.$selectedCategory->getName(),
            'breadcrumbs' => $breadcrumbs,
            'categories' => $categories,
            'form_add' => $form_add->createView(),
            'selectedCategory' => $selectedCategory
        ]);
    }
    /**
     * @Route("/adminpanel/categories/{id}/delete", name="adminCategoryDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteCategory(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

            if($category)
            {
                // check if this category isn't a parent category - if it is - move subcategories to parent of this category or set parent to null
                $categoriesRepo = $this->getDoctrine()->getRepository(Category::class);

                $subcategories = $category->getSubcategories();
                if($subcategories !== null) {
                    foreach ($subcategories as $subcategory) {
                        if($subcategory->getParent() !== null)
                            $subcategory->setParent($category->getParent());
                        else
                            $subcategory->setParent(null);

                        // save it
                        $entityManager->flush();
                    }
                }


                // finally, delete the category
                $entityManager->remove($category);
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
