<?php

namespace AppBundle\Tests\Repository;

use AppBundle\Entity\Film;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class FilmRepositoryTest extends WebTestCase
{
//    /**
//     * Set up tests
//     */
//    public function setUp()
//    {
//        $this->loadFixtures(array(
//            'AppBundle\DataFixtures\ORM\Categories',
//            'AppBundle\DataFixtures\ORM\Posts',
//        ));
//    }

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
