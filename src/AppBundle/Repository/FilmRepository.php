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
            ->findEnabledSortedByCreatedDateDescOfCategorySlugQB()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function findEnabledSortedByCreatedDateDescOfCategorySlugQB()
    {
        return $this
            ->createBaseQuery();
    }
}
