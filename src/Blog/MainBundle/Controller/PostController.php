<?php

namespace Blog\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blog\MainBundle\Entity\Post;

class PostController extends BaseController
{
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
}
