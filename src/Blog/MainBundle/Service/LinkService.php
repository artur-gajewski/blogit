<?php

namespace Blog\MainBundle\Service;

use Blog\MainBundle\Entity\Link;

use Blog\MainBundle\Entity\LinkRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\SecurityContext;

use Exception;

class LinkService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var LinkRepository
     */
    protected $repository;

    /**
     * @var SecurityContext
     */
    protected $security;

    /**
     * @param EntityManager     $em
     * @param LinkRepository    $repository
     * @param SecurityContext   $security
     */
    public function __construct(
        EntityManager       $em,
        LinkRepository      $repository,
        SecurityContext     $security)
    {
        $this->em         = $em;
        $this->repository = $repository;
        $this->security   = $security;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->repository->findBy(
            array(),
            array('title' => 'ASC')
        );
    }

    /**
     * @param  int $id
     * @return Link
     */
    public function getLinkById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Save a Link
     *
     * @param  Link $link
     * @return link
     */
    public function saveLink(Link $link)
    {
        $url = $link->getUrl();

        $url = str_replace('http://',  '', $url);
        $url = str_replace('https://', '', $url);

        $link->setUrl($url);

        $this->em->persist($link);
        $this->em->flush();

        return $link;
    }

    /**
     * Delete a link
     *
     * @param  Link $link
     * @return Link
     */
    public function deleteLink(Link $link)
    {
        $this->em->remove($link);
        $this->em->flush();

        return $link;
    }
}
