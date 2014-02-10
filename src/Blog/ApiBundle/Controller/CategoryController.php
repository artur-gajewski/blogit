<?php

namespace Blog\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\ApiBundle\Controller\BaseController;
use Blog\MainBundle\Entity\Category;
use Blog\MainBundle\Entity\Post;

class CategoryController extends BaseController
{
    /**
     * @Route("/api/v1/categories", name="api_categories")
     * @Method("GET")
     */
    public function categoriesAction()
    {
        $categoryService = $this->getCategoryService();
        $categories = $categoryService->getCategories();
        $data = array();

        foreach ($categories as $category) {
            $data[] = $this->getCategoryData($category);
        }

        $response = $this->createResponse($data);
        return $response;
    }

    /**
     * @Route("/api/v1/categories/{categoryId}", requirements={"categoryId" = "\d+"}, name="api_category")
     * @Method("GET")
     */
    public function categoryAction($categoryId)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();
        $category = $categoryService->getCategoryById($categoryId);
        $posts = $postService->getPostsByCategory($category);

        $data = array();

        foreach ($posts as $post) {
            $data[] = $this->getPostData($post);
        }

        $response = $this->createResponse($data);
        return $response;
    }

}
