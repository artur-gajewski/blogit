<?php

namespace Blog\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * @param string $order
     * @param bool $showCurrentOnly
     * @return array
     */
    public function findPosts($order = "DESC", $showCurrentOnly = false)
    {
        $em = $this->getEntityManager();

        $dql =  'SELECT p FROM Blog\MainBundle\Entity\Post p ';
        $dql .= 'WHERE p.status = 1 ';
        if ($showCurrentOnly) {
            $dql .= 'AND (';
            $dql .= '(p.startingDate is null and p.endingDate is null) OR (CURRENT_DATE() >= p.startingDate AND CURRENT_DATE() <= p.endingDate) OR (CURRENT_DATE() >= p.startingDate AND p.endingDate is null) OR (p.startingDate is null AND CURRENT_DATE() <= p.endingDate)';
            $dql .= ') ';
        }
        $dql .= 'ORDER BY p.created ' . $order;

        $query = $em->createQuery($dql);
        return $query->getResult();
    }
}
