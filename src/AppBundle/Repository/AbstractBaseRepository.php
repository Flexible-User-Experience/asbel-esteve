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
    public function findAllSortedByTitle()
    {
        return $this
            ->findAllEnabledQB()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function findAllSortedByTitleQB()
    {
        return $this
            ->createBaseQuery()
            ->orderBy('entity.title', 'ASC');
    }

    /**
     * @return ArrayCollection
     */
    public function findAllEnabled()
    {
        return $this
            ->findAllEnabledQB()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function findAllEnabledQB()
    {
        return $this
            ->createEnabledQuery();
    }

    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByTitle()
    {
        return $this
            ->findAllEnabledSortedByTitleQB()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function findAllEnabledSortedByTitleQB()
    {
        return $this
            ->createEnabledQuery()
            ->orderBy('entity.title', 'ASC');
    }

    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByCreatedDateDesc()
    {
        return $this
            ->findAllEnabledSortedByCreatedDateDescQB()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function findAllEnabledSortedByCreatedDateDescQB()
    {
        return $this
            ->createEnabledQuery()
            ->orderBy('entity.createdAt', 'DESC');
    }

    /**
     * @return QueryBuilder
     */
    private function createEnabledQuery()
    {
        return $this
            ->createBaseQuery()
            ->where('entity.enabled = :enabled')
            ->setParameter('enabled', true);
    }

    /**
     * @return QueryBuilder
     */
    private function createBaseQuery()
    {
        return $this->createQueryBuilder('entity');
    }
}
