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
            ->createQueryBuilder('f')
            ->select('f, c')
            ->join('f.categories', 'c')
            ->where('f.enabled = :enabled')
            ->andWhere('c.slug = :slug')
            ->setParameter('enabled', true)
            ->setParameter('slug', $slug)
            ->orderBy('f.createdAt', 'DESC');
    }
}
