<?php


namespace App\Controller\admin\categories;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


        // add some breadcrumbs
        $breadcrumbs = [
            ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
            ['Kategorie ofert', $this->generateUrl('adminCategories')]
        ];

        // Add to breadcrumbs
        if($selectedCategory !== null) {
            $currentParent = $selectedCategory;
            for($i = 0; $i <= count($categories); $i++) {
                if($currentParent->getParentCategory() === null)
                    break;

                $parentOf = $currentParent->getParentCategory();
                array_push($breadcrumbs, [$parentOf->getName(), $this->generateUrl("adminCategories", ['category' => $parentOf->getId()])]);
            }
            array_push($breadcrumbs, [$selectedCategory->getName(), $this->generateUrl("adminCategories", ['category' => $selectedCategory->getId()])]);
        }

        return $this->render('admin/pages/categories/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => $selectedCategory === null ? 'Kategorie ofert' : 'Podkategorie oferty'.$selectedCategory,
            'breadcrumbs' => $breadcrumbs,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory
        ]);
    }
}
