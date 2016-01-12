<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Film;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;

/**
 * Class FilmRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   David Romaní <david@flux.cat>
 */
class FilmRepository extends AbstractBaseRepository
{
    /**
     * @param $slug
     *
     * @return Film
     */
    public function findOneBySlugWithJoin($slug)
    {
        return $this
            ->findOneBySlugWithJoinQB($slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $slug
     *
     * @return QueryBuilder
     */
    public function findOneBySlugWithJoinQB($slug)
    {
        return $this
            ->createQueryBuilder('f')
            ->select('f, c')
            ->join('f.categories', 'c')
            ->where('f.slug = :slug')
            ->setParameter('slug', $slug);
    }

    /**
     * @return array
     */
    public function findAllEnabledSortedByCreatedDateDescWithJoin()
    {
        return $this
            ->findAllEnabledSortedByCreatedDateDescWithJoinQB()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function findAllEnabledSortedByCreatedDateDescWithJoinQB()
    {
        return $this
            ->createQueryBuilder('f')
            ->select('f, c')
            ->join('f.categories', 'c')
            ->where('f.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('f.createdAt', 'DESC');
    }

    /**
     * @param $slug
     *
     * @return ArrayCollection
     */
    public function findEnabledSortedByCreatedDateDescOfCategorySlug($slug)
    {
        return $this
            ->findEnabledSortedByCreatedDateDescOfCategorySlugQB($slug)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $slug
     *
     * @return QueryBuilder
     */
    public function findEnabledSortedByCreatedDateDescOfCategorySlugQB($slug)
    {
        return $this
            ->findAllEnabledSortedByCreatedDateDescWithJoinQB()
            ->andWhere('c.slug = :slug')
            ->setParameter('slug', $slug);
    }
}
