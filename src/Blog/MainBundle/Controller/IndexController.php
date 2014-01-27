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

        return $this->createResponseArray(
            array(
                'articles' => $posts,
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

        $post = new Post();
        $post->setTitle($request->get('title'));
        $post->setContent($request->get('content'));

        if ($request->getMethod() == 'POST') {
            $postService->savePost($post);
            echo "OK";
        }


        $posts = $postService->getPosts();

        return $this->createResponseArray(
            array(
                'articles' => $posts,
            )
        );
    }
}
