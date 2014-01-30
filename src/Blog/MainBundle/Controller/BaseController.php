<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BaseController extends Controller
{
    public function createResponseArray($array = null)
    {
        $categoryService = $this->getCategoryService();

        $categories = $categoryService->getCategories();

        $common =  array(
            'categories' => $categories,
        );

        if (!empty($array)) {
            return array_merge_recursive($array, $common);
        }

        return $common;
    }

    /**
     * @return PostService
     */
    public function getPostService()
    {
        return $this->container->get('blog_main.service.post');
    }

    /**
     * @return CategoryService
     */
    public function getCategoryService()
    {
        return $this->container->get('blog_main.service.category');
    }

    public function renderPostNotFound()
    {
        $categoryService = $this->getCategoryService();

        $categories = $categoryService->getCategories();

        $common =  array(
            'categories' => $categories,
        );

        return $this->render('BlogMainBundle:Post:notfound.html.twig',
            $common
        );
    }
}
