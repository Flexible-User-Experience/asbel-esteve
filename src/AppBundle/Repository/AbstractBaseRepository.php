<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

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
    public function findAllEnabledSortedByTitle()
    {
        return $this->createQueryBuilder('t')
            ->where('t.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('t.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
