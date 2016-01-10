<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AbstractBaseTest;

/**
 * Class DefaultControllerTest
 *
 * @category Test
 * @package  AppBundle\Tests\Controller\Frontend
 * @author   David Romaní <david@flux.cat>
 */
class FrontendTest extends AbstractBaseTest
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
        $client->request('GET', $url);
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
            array('/category/films/'),
            array('/category/artwork/'),
            array('/page/words-interviews-screeings-and-news/'),
        );
    }

    /**
     * Test HTTP request is not found
     */
    public function testNotFoundUrls()
    {
        $client = static::makeClient();
        $client->request('GET', '/not-found-url');
        $this->assertStatusCode(404, $client);
    }
}
