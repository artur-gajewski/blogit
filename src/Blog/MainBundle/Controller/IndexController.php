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

            $category = $categoryService->getCategoryById($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);

            $this->get('session')->getFlashBag()->add(
                'info',
                'New article has been saved!'
            );

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/edit/{postId}", name="edit_post")
     * @Template("BlogMainBundle:Index:editPost.html.twig")
     */
    public function editPostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();
        $post = $postService->getPostById($postId);

        if ($request->getMethod() == 'POST') {
            $post->setTitle($request->get('title'));

            $category = $categoryService->getCategoryById($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);

            $this->get('session')->getFlashBag()->add(
                'info',
                'Your changes were saved!'
            );
        }

        return $this->createResponseArray(
            array(
                'article' => $post,
            )
        );
    }

    /**
     * @Route("/delete/{postId}", name="delete_post")
     * @Template("BlogMainBundle:Index:deletePost.html.twig")
     */
    public function deletePostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $post = $postService->getPostById($postId);

        if ($request->getMethod() == 'POST') {
            $postService->deletePost($post);

            $this->get('session')->getFlashBag()->add(
                'info',
                'Article has been deleted!'
            );

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->createResponseArray(
            array(
                'article' => $post,
            )
        );
    }

    /**
     * @Route("/view/{postId}", name="view_post")
     * @Template("BlogMainBundle:Index:viewPost.html.twig")
     */
    public function viewPostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $post = $postService->getPostById($postId);

        return $this->createResponseArray(
            array(
                'article' => $post,
            )
        );
    }
}
