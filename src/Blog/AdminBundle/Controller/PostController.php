<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Controller\BaseController;
use Blog\MainBundle\Entity\Post;

class PostController extends BaseController
{
    /**
     * @Route("/admin/post/new", name="new_post")
     * @Template("BlogAdminBundle:Post:new.html.twig")
     */
    public function newPostAction(Request $request)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();

        if ($request->getMethod() == 'POST') {
            $post = new Post();
            $post->setTitle($request->get('title'));
            $post->setStatus($request->get('status'));

            if ($request->get('startingDate') != '') {
                $startingDate = new \DateTime($request->get('startingDate'));
                $post->setStartingDate($startingDate);
            }

            if ($request->get('endingDate') != '') {
                $endingDate = new \DateTime($request->get('endingDate'));
                $post->setStartingDate($endingDate);
            }

            $category = $categoryService->getCategoryById($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);

            if ($post->getStatus() == 1) {
                $this->get('session')->getFlashBag()->add(
                    'info',
                    $this->get('translator')->trans('new.post_saved_and_published')
                );
            } elseif ($post->getStatus() == 2) {
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    $this->get('translator')->trans('new.post_saved_but_not_published')
                );
            }

            return $this->redirect(
                $this->generateUrl('view_post', array(
                    'postId' => $post->getId(),
                    'slug' => $post->getSlug(),
                ))
            );
        }

        return $this->createResponseArray();
    }

    /**
     * @Route("/admin/post/edit/{postId}", name="edit_post")
     * @Template("BlogAdminBundle:Post:edit.html.twig")
     */
    public function editPostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $categoryService = $this->getCategoryService();
        $post = $postService->getPostById($postId);

        if ($request->getMethod() == 'POST') {
            $post->setTitle($request->get('title'));
            $post->setStatus($request->get('status'));

            if ($request->get('startingDate') != '') {
                $startingDate = new \DateTime($request->get('startingDate'));
                $post->setStartingDate($startingDate);
            }

            if ($request->get('endingDate') != '') {
                $endingDate = new \DateTime($request->get('endingDate'));
                $post->setEndingDate($endingDate);
            }

            $newDate = new \DateTime($request->get('created'));
            $post->setCreated($newDate);

            $category = $categoryService->getCategoryById($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.changes_saved')
            );

            return $this->redirect(
                $this->generateUrl('view_post', array(
                    'postId' => $post->getId(),
                    'slug' => $post->getSlug(),
                ))
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
     * @Template("BlogAdminBundle:Post:delete.html.twig")
     */
    public function deletePostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $post = $postService->getPostById($postId);

        if ($request->getMethod() == 'POST') {
            $postService->deletePost($post);

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('common.post_deleted')
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
     * @Route("/admin/unpublished", name="list_unpublished_posts")
     * @Template("BlogAdminBundle:Post:unpublished.html.twig")
     */
    public function unpublishedPostsAction(Request $request)
    {
        $postService = $this->getPostService();
        $posts = $postService->getUnpublishedPosts();

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
