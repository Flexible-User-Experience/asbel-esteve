<?php

namespace AppBundle\Tests\Repository;

use AppBundle\Entity\Film;
use AppBundle\Tests\AbstractBaseTest;

/**
 * Class FilmRepositoryTest
 *
 * @category Test
 * @package  AppBundle\Tests\Repository
 * @author   David Romaní <david@flux.cat>
 */
class FilmRepositoryTest extends AbstractBaseTest
{
    /**
     * Main test
     */
    public function testMain()
    {
        $enabledFilms = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Film')->findAllEnabledSortedByTitle();
        $allFilms = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Film')->findAll();
        $enabledItems = 0;
        /** @var Film $film */
        foreach ($allFilms as $film) {
            if ($film->getEnabled()) {
                $enabledItems++;
            }
        }

        $this->assertEquals(count($enabledFilms), $enabledItems);
    }
}
