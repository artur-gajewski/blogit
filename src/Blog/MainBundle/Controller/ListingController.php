<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Post;

class ListingController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     * @Template("BlogMainBundle:Common:listing.html.twig")
     */
    public function indexAction()
    {
        $postService = $this->getPostService();
        $posts = $postService->getPosts();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->createResponseArray(
            array(
                'show_category' => true,
                'pagination' => $pagination,
            )
        );
    }

    /**
     * @Route("/ordered", name="ordered")
     * @Template("BlogMainBundle:Common:listing.html.twig")
     */
    public function orderedAction()
    {
        $postService = $this->getPostService();
        $posts = $postService->getPosts('ASC');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->createResponseArray(
            array(
                'show_category' => true,
                'pagination' => $pagination,
            )
        );
    }

    /**
     * @Route("/search", name="search")
     * @Template("BlogMainBundle:Common:listing.html.twig")
     */
    public function searchAction(Request $request)
    {
        $postService = $this->getPostService();
        $searchPhrase = $request->get('searchPhrase');

        $posts = $postService->search($searchPhrase);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->createResponseArray(
            array(
                'show_category' => false,
                'pagination' => $pagination,
            )
        );
    }

    /**
     * @Route("/category/{slug}", name="category")
     * @Template("BlogMainBundle:Common:listing.html.twig")
     */
    public function categoryAction($slug)
    {

        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();

        $category = $categoryService->getCategoryBySlug($slug);

        $posts = $postService->getPostsByCategory($category);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->createResponseArray(
            array(
                'show_category' => false,
                'current_category' => $category,
                'pagination' => $pagination,
            )
        );
    }
}
