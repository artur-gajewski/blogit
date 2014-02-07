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
class PostController extends BaseController
{
    /**
     * @Route("/api/v1/posts", name="api_posts")
     * @Method({"GET"})
     */
    public function postsAction()
    {
        $postService = $this->getPostService();
        $posts = $postService->getPosts();
        $response = array();

        foreach ($posts as $post) {
            $response[] = $this->getPostData($post);
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/v1/posts/ordered", name="api_posts_ordered")
     * @Method({"GET"})
     */
    public function orderedAction()
    {
        $postService = $this->getPostService();
        $posts = $postService->getPosts('ASC');
        $response = array();

        foreach ($posts as $post) {
            $response[] = $this->getPostData($post);
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/v1/posts/{postId}", requirements={"postId" = "\d+"}, name="api_post_view")
     * @Method({"GET"})
     */
    public function viewAction(Request $request, $postId)
    {
        $postService = $this->getPostService();
        $post = $postService->getPostById($postId);

        $response = $this->getPostData($post);

        return new JsonResponse($response);
    }

}
