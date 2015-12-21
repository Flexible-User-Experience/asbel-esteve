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
     * Test HTTP request is successful
     *
     * @dataProvider provideSuccessfulUrls
     * @param string $url
     */
    public function testSuccessfulUrls($url)
    {
        $client = static::makeClient();
        $client->request('GET', '/');
        $this->assertStatusCode(200, $client);
    }

    /**
     * Successful Urls provider
     *
     * @return array
     */
    public function provideSuccessfulUrls()
    {
        return array(
            array('/'),
            array('/films'),
            array('/artwork'),
            array('/news'),
        );
    }

    /**
     * Test HTTP request is not found
     */
    public function testNotFoundUrls()
    {
        $client = static::makeClient();
        $client->request('GET', '/bad-request-error');
        $this->assertStatusCode(404, $client);
    }
}
