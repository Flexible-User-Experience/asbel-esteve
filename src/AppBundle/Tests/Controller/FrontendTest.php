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
            array('/category/films'),
            array('/category/artwork'),
            array('/test-title'),
            array('/page/words-interviews-screeings-and-news'),
            array('/rss/sitemap.default.xml'),
        );
    }

    /**
     * Test HTTP request is not found
     */
    public function testNotFoundUrls()
    {
        $client = static::makeClient();
        $client->request('GET', '/category/not-found-url');
        $client->request('GET', '/page/not-found-url');
        $this->assertStatusCode(404, $client);
    }

    /**
     * Test HTTP request is redirected
     *
     * @dataProvider provideRedirectedUrls
     *
     * @param string $url
     */
    public function testFrontendPagesAreRedirected($url)
    {
        $client = $this->createClient();           // anonymous user
        $client->request('GET', $url);

        $this->assertStatusCode(301, $client);
    }

    /**
     * Urls provider.
     *
     * @return array
     */
    public function provideRedirectedUrls()
    {
        return array(
            array('/category/films/'),
            array('/category/not-found-url/'),
        );
    }

    /**
     * Test contact formquest is successful
     */
    public function testContactForm()
    {
        $client = static::makeClient();
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('OK')->form(array(
            'contact_message[message]' => 'Test message',
            'contact_message[email]' => 'test@test.com',
        ));
        $pendingMessagesAmount = $this->getContainer()->get('doctrine')->getRepository('AppBundle:ContactMessage')->getPendingMessagesAmount();
        $client->submit($form);

        $this->assertEquals($pendingMessagesAmount + 1, $this->getContainer()->get('doctrine')->getRepository('AppBundle:ContactMessage')->getPendingMessagesAmount());
    }
}
