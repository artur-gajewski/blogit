<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

            $category = $categoryService->getCategoryById($request->get('category'));
            $post->setCategory($category);

            $post->setContent($request->get('content'));
            $postService->savePost($post);

            $this->get('session')->getFlashBag()->add(
                'info',
                'New post has been saved!'
            );

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
     * @Route("/post/{postId}", name="view_post")
     * @Template("BlogMainBundle:Post:view.html.twig")
     */
    public function viewPostAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $post = $postService->getPostById($postId);

        return $this->createResponseArray(
            array(
                'post' => $post,
            )
        );
    }
}
