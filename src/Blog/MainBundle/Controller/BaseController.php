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
        $postService = $this->getPostService();
        $linkService = $this->getLinkService();
        $updateService = $this->getUpdateService();

        $categories = $categoryService->getCategories();
        $unpublished = $postService->getUnpublishedPosts();
        $links = $linkService->getLinks();
        $updates = $updateService->getUpdates();

        $common =  array(
            'categories' => $categories,
            'unpublished' => $unpublished,
            'links' => $links,
            'updates' => $updates,
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

    /**
     * @return LinkService
     */
    public function getLinkService()
    {
        return $this->container->get('blog_main.service.link');
    }

    /**
     * @return UpdateService
     */
    public function getUpdateService()
    {
        return $this->container->get('blog_main.service.update');
    }

    public function renderPostNotFound()
    {
        $categoryService = $this->getCategoryService();
        $postService = $this->getPostService();

        $categories = $categoryService->getCategories();
        $unpublished = $postService->getUnpublishedPosts();

        $common =  array(
            'categories' => $categories,
            'unpublished' => $unpublished,
        );

        return $this->render('BlogMainBundle:Post:notfound.html.twig',
            $common
        );
    }
}
