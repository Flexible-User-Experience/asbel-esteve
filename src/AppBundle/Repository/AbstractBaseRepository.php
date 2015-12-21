<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract base class
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   David Romaní <david@flux.cat>
 */
abstract class AbstractBaseRepository extends EntityRepository
{
    /**
     * @return ArrayCollection
     */
    public function findAllEnabled()
    {
        return $this->createEnabledQuery()
            ->orderBy('t.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByTitle()
    {
        return $this->createEnabledQuery()
            ->orderBy('t.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByCreatedDateDesc()
    {
        return $this->createEnabledQuery()
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    private function createEnabledQuery()
    {
        return $this->createBaseQuery()
            ->where('t.enabled = :enabled')
            ->setParameter('enabled', true);
    }

    /**
     * @return QueryBuilder
     */
    private function createBaseQuery()
    {
        return $this->createQueryBuilder('t');
    }
}
