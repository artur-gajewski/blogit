<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Blog\Category;

class CategoryController extends BaseController
{
    /**
     * @Route("/admin/category/new", name="new_category")
     * @Template("BlogMainBundle:Category:new.html.twig")
     */
    public function newCategoryAction(Request $request)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();

        if ($request->getMethod() == 'POST') {
            $category = new Category();

            $category->setTitle($request->get('title'));

            $categoryService->saveCategory($category);

            $this->get('session')->getFlashBag()->add(
                'info',
                'New category has been saved!'
            );

            return $this->redirect($this->generateUrl('list_categories'));
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/categoru/edit/{categoryId}", name="edit_category")
     * @Template("BlogMainBundle:Category:edit.html.twig")
     */
    public function editCategoryAction(Request $request, $categoryId)
    {
        $categoryService = $this->getCategoryService();
        $category = $categoryService->getCategoryById($categoryId);

        if ($request->getMethod() == 'POST') {
            $category->setTitle($request->get('title'));

            $categoryService->saveCategory($category);

            $this->get('session')->getFlashBag()->add(
                'info',
                'Your changes were saved!'
            );
        }

        return $this->createResponseArray(
            array(
                'category' => $category,
            )
        );
    }

    /**
     * @Route("/admin/category/delete/{categoryId}", name="delete_category")
     * @Template("BlogMainBundle:Category:delete.html.twig")
     */
    public function deleteCategoryAction(Request $request, $categoryId)
    {
        $categoryService = $this->getCategoryService();
        $category = $categoryService->getCategoryById($categoryId);

        if ($request->getMethod() == 'POST') {
            $categoryService->deleteCategory($category);

            $this->get('session')->getFlashBag()->add(
                'info',
                'Category has been deleted!'
            );

            return $this->redirect($this->generateUrl('list_categories'));
        }

        return $this->createResponseArray(
            array(
                'category' => $category,
            )
        );
    }

    /**
     * @Route("/admin/category", name="list_categories")
     * @Template("BlogMainBundle:Category:listing.html.twig")
     */
    public function listingAction(Request $request)
    {
        return $this->createResponseArray();
    }
}
