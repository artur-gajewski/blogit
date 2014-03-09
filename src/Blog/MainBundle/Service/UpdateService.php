<?php

namespace Blog\MainBundle\Service;

use Blog\MainBundle\Entity\Update;

use Blog\MainBundle\Entity\UpdateRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\SecurityContext;

use Exception;

class UpdateService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UpdateRepository
     */
    protected $repository;

    /**
     * @var SecurityContext
     */
    protected $security;

    /**
     * @param EntityManager     $em
     * @param UpdateRepository  $repository
     * @param SecurityContext   $security
     */
    public function __construct(
        EntityManager       $em,
        UpdateRepository  $repository,
        SecurityContext     $security)
    {
        $this->em         = $em;
        $this->repository = $repository;
        $this->security   = $security;
    }

    /**
     * @return array
     */
    public function getUpdates()
    {
        return $this->repository->findAll();
    }

    /**
     * @param  int $id
     * @return Update
     */
    public function getUpdateById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Delete an update
     *
     * @param  Update $update
     * @return Update
     */
    public function deleteUpdate(Update $update)
    {
        $this->em->remove($update);
        $this->em->flush();

        return $update;
    }

    /**
     * Save an update
     *
     * @param  Update $update
     * @return Update
     */
    public function saveUpdate(Update $update)
    {
        $this->em->persist($update);
        $this->em->flush();

        return $update;
    }

}
