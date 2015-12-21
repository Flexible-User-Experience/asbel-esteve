<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::makeClient();
        $client->request('GET', '/');
        $this->assertStatusCode(200, $client);
    }
}
