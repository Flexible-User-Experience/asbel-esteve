<?php

namespace AppBundle\Repository;

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
    public function findAllEnabledSortedByCreatedDateDescWithJoin()
    {
        return $this
            ->findAllEnabledSortedByCreatedDateDescWithJoinQB()
            ->getQuery()
            ->getResult();
    }

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
