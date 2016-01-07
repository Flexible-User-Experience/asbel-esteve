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
     * Set up test
     */
    public function setUp()
    {
        $this->runCommand('hautelook_alice:doctrine:fixtures:load');
    }

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
        $client->request('GET', '/not-found-url');
        $this->assertStatusCode(404, $client);
    }
}
