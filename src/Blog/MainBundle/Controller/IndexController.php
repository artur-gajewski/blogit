<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Blog\Post;

class IndexController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     * @Template("BlogMainBundle:Index:index.html.twig")
     */
    public function indexAction()
    {
        $postService = $this->getPostService();
        $posts = $postService->getPosts();
        $posts = array_reverse($posts);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->createResponseArray(
            array(
                'pagination' => $pagination,
            )
        );
    }

    /**
     * @Route("/category/{slug}", name="category")
     * @Template("BlogMainBundle:Index:index.html.twig")
     */
    public function categoryAction($slug)
    {

        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();

        $category = $categoryService->getCategoryBySlug($slug);

        $posts = $postService->getPostsByCategory($category);
        $posts = array_reverse($posts);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $this->get('request')->query->get('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->createResponseArray(
            array(
                'pagination' => $pagination,
            )
        );
    }

    /**
     * @Route("/new", name="new_post")
     * @Template("BlogMainBundle:Index:newPost.html.twig")
     */
    public function newPostAction(Request $request)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();

        $categories = $categoryService->getCategories();

        if ($request->getMethod() == 'POST') {
            $post = new Post();

            $post->setTitle($request->get('title'));

            $category = $categoryService->getCategoryBySlug($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);
        }

        return $this->createResponseArray();
    }
}
