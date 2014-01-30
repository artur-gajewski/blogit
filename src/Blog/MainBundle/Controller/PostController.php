<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Blog\Post;

class PostController extends BaseController
{
    /**
     * @Route("/admin/post/new", name="new_post")
     * @Template("BlogMainBundle:Post:new.html.twig")
     */
    public function newPostAction(Request $request)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();

        if ($request->getMethod() == 'POST') {
            $post = new Post();
            $post->setTitle($request->get('title'));
            $post->setStatus($request->get('status'));

            $category = $categoryService->getCategoryById($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);

            if ($post->getStatus() == 1) {
                $this->get('session')->getFlashBag()->add(
                    'info',
                    'New post has been saved!'
                );
            } elseif ($post->getStatus() == 2) {
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'Post has been saved, but is has not been published yet!'
                );
            }

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/post/edit/{postId}", name="edit_post")
     * @Template("BlogMainBundle:Post:edit.html.twig")
     */
    public function editPostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();
        $post = $postService->getPostById($postId);

        if ($request->getMethod() == 'POST') {
            $post->setTitle($request->get('title'));
            $post->setStatus($request->get('status'));

            $newDate = new \DateTime($request->get('created'));
            $post->setCreated($newDate);

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
                'post' => $post,
            )
        );
    }

    /**
     * @Route("/admin/post/delete/{postId}", name="delete_post")
     * @Template("BlogMainBundle:Post:delete.html.twig")
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
                'post' => $post,
            )
        );
    }

    /**
     * @Route("/post/{postId}/{slug}", name="view_post")
     * @Template("BlogMainBundle:Post:view.html.twig")
     */
    public function viewPostAction(Request $request, $postId, $slug)
    {
        $securityContext = $this->container->get('security.context');
        $postService = $this->getPostService();
        $post = $postService->getPostById($postId);

        if (!$post) {
            return new Response($this->renderPostNotFound());
        } elseif (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($post->getStatus() == 2) {
                return new Response($this->renderPostNotFound());
            }
        }

        return $this->createResponseArray(
            array(
                'show_category' => true,
                'post' => $post,
            )
        );
    }

    /**
     * @Route("/admin/unpublished", name="list_unpublished_posts")
     * @Template("BlogMainBundle:Post:unpublished.html.twig")
     */
    public function unpublishedPostsAction(Request $request)
    {
        $postService = $this->getPostService();
        $posts = $postService->getUnpublishedPosts();
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
}
