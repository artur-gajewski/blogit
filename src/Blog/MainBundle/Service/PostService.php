<?php

namespace Blog\MainBundle\Service;

use Blog\MainBundle\Entity\Blog\Post;

use Blog\MainBundle\Entity\Blog\PostRepository;
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
        $this->em               = $em;
        $this->repository       = $repository;
        $this->security         = $security;
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->repository->findAll();
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
}
