<?php

namespace AppBundle\Tests\Repository;

use AppBundle\Entity\Film;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class FilmRepositoryTest extends WebTestCase
{
    /**
     * Main test
     */
    public function testEnabled()
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
