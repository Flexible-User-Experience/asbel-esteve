<?php

namespace AppBundle\Tests\Controller\Frontend;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @category Test
 * @package  AppBundle\Tests\Controller\Frontend
 * @author   David Romaní <david@flux.cat>
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Main test
     */
    public function testIndex()
    {
        $client = static::makeClient();
        $client->request('GET', '/');
        $this->assertStatusCode(200, $client);
    }
}
