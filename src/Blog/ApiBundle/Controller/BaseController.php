<?php

namespace Blog\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Blog\MainBundle\Entity\Category;
use Blog\MainBundle\Entity\Post;

class BaseController extends Controller
{
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
     * Fetch post data into array
     *
     * @param Post $post
     * @return array
     */
    public function getPostData(Post $post)
    {
        $url = $this->generateUrl('api_post_view',
            array(
                'postId' => $post->getId(),
            ),
            true
        );

        return array(
            'id'       => $post->getId(),
            'slug'     => $post->getSlug(),
            'title'    => $post->getTitle(),
            'content'  => $post->getContent(),
            'created'  => $post->getCreated(),
            'modified' => $post->getModified(),
            'status'   => $post->getStatus(),
            'url'      => $url,
        );
    }

    /**
     * Fetch category data into array
     *
     * @param Category $category
     * @return array
     */
    public function getCategoryData(Category $category)
    {
        $url = $this->generateUrl('api_category',
            array(
                'categoryId' => $category->getId(),
            ),
            true
        );

        return array(
            'id'         => $category->getId(),
            'slug'       => $category->getSlug(),
            'title'      => $category->getTitle(),
            'post_count' => $category->getCountPosts(),
            'url'        => $url,
        );
    }

    /**
     * Create JSON/JSONP response
     *
     * @param array $data
     * @return Response
     */
    public function createResponse(array $data)
    {
        if (!empty($_GET['callback'])) {
            $content = $_GET['callback'] . '(' . json_encode($data) . ');';
        } else {
            $content = json_encode($data);
        }

        $response = new Response(
            $content,
            Response::HTTP_OK,
            array(
                'content-type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Expose-Headers' => 'Access-Control-Allow-Origin',
            )
        );

        return $response;

    }
}
