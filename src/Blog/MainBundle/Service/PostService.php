<?php

namespace Blog\MainBundle\Service;

use Blog\MainBundle\Entity\Post;

use Blog\MainBundle\Entity\PostRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\SecurityContext;

use Exception;

class PostService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @var SecurityContext
     */
    protected $security;

    /**
     * @param EntityManager     $em
     * @param PostRepository  $repository
     * @param SecurityContext   $security
     */
    public function __construct(
        EntityManager       $em,
        PostRepository      $repository,
        SecurityContext     $security)
    {
        $this->em         = $em;
        $this->repository = $repository;
        $this->security   = $security;
    }

    /**
     * @return array Post
     */
    public function getPosts($order = 'DESC', $showOnlyCurrent = false)
    {
        return $this->repository->findPosts($order, $showOnlyCurrent);
    }

    /**
     * @return array Post
     */
    public function getUnpublishedPosts()
    {
        return $this->repository->findBy(
            array('status' => 2),
            array('created' => 'DESC')
        );
    }

    /**
     * @return array
     */
    public function getPostsByCategory($category)
    {
        return $this->repository->findBy(
            array(
                'category' => $category,
                'status' => 1
            ),
            array('created' => 'DESC')
        );
    }

    /**
     * @param  int $id
     * @return Post
     */
    public function getPostById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param  int $id
     * @return Post
     */
    public function getPostByIdAndSlug($postId, $slug)
    {
        return $this->repository->getPostByIdAndSlug($postId, $slug);
    }

    /**
     * Save a post
     *
     * @param  Post $post
     * @return Post
     */
    public function savePost(Post $post)
    {
        $this->em->persist($post);
        $this->em->flush();

        return $post;
    }

    /**
     * Delete a post
     *
     * @param  Post $post
     * @return Post
     */
    public function deletePost(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();

        return $post;
    }

    /**
     * @param $string
     * @return array Post
     */
    public function search($string)
    {
        $searchPhrase = '%' . $string . '%';

        $query = $this->em->createQuery(
            "SELECT p FROM Blog\MainBundle\Entity\Post p WHERE p.status = 1 AND (p.title LIKE :search_title or p.content LIKE :search_content) ORDER BY p.created DESC"
        );

        $query->setParameter("search_title", $searchPhrase);
        $query->setParameter("search_content", $searchPhrase);

        return $query->getResult();
    }
}
