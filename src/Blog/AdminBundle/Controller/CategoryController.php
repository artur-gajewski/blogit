<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Category;
use Blog\MainBundle\Controller\BaseController;

class CategoryController extends BaseController
{
    /**
     * @Route("/admin/category/new", name="new_category")
     * @Template("BlogAdminBundle:Category:new.html.twig")
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
                $this->get('translator')->trans('common.category_created')
            );

            return $this->redirect($this->generateUrl('list_categories'));
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/categoru/edit/{categoryId}", name="edit_category")
     * @Template("BlogAdminBundle:Category:edit.html.twig")
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
                $this->get('translator')->trans('common.changes_saved')
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
     * @Template("BlogAdminBundle:Category:delete.html.twig")
     */
    public function deleteCategoryAction(Request $request, $categoryId)
    {
        $categoryService = $this->getCategoryService();
        $category = $categoryService->getCategoryById($categoryId);

        if ($request->getMethod() == 'POST') {
            $categoryService->deleteCategory($category);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.category_deleted')
            );

            return $this->redirect($this->generateUrl('list_categories'));
        }

        return $this->createResponseArray(
            array(
                'category' => $category,
            )
        );
    }
}
