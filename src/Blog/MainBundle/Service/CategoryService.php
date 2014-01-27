<?php

namespace Blog\MainBundle\Service;

use Blog\MainBundle\Entity\Blog\Category;

use Blog\MainBundle\Entity\Blog\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\SecurityContext;

use Exception;

class CategoryService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var SecurityContext
     */
    protected $security;

    /**
     * @param EntityManager     $em
     * @param CategoryRepository  $repository
     * @param SecurityContext   $security
     */
    public function __construct(
        EntityManager       $em,
        CategoryRepository  $repository,
        SecurityContext     $security)
    {
        $this->em               = $em;
        $this->repository       = $repository;
        $this->security         = $security;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->repository->findAll();
    }

    /**
     * @return array
     */
    public function getCategoryBySlug($slug)
    {
        return $this->repository->findOneBy(
            array('slug' => $slug)
        );
    }

    /**
     * @param  int $id
     * @return Post
     */
    public function getCategoryById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Save a Category
     *
     * @param  Category $category
     * @return Category
     */
    public function saveCategory(Category $category)
    {
        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    /**
     * Delete a category
     *
     * @param  Category $category
     * @return Category
     */
    public function deleteCategory(Category $category)
    {
        $this->em->remove($category);
        $this->em->flush();

        return $category;
    }
}
