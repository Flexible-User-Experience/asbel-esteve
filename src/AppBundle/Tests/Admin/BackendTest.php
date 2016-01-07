<?php

namespace AppBundle\Tests\Admin;

use AppBundle\Tests\AbstractBaseTest;

/**
 * Class BackendTest
 *
 * @category Test
 * @package  AppBundle\Tests\Admin
 * @author   David Romaní <david@flux.cat>
 */
class BackendTest extends AbstractBaseTest
{
    /**
     * Test admin login request is successful
     */
    public function testAdminLoginPageIsSuccessful()
    {
        $client = $this->createClient();           // anonymous user
        $client->request('GET', '/admin/login');

        $this->assertStatusCode(200, $client);
    }

    /**
     * Test HTTP request is successful
     *
     * @dataProvider provideSuccessfulUrls
     * @param string $url
     */
    public function testAdminPagesAreSuccessful($url)
    {
        $client = $this->makeClient(true);         // authenticated user
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
            array('/admin/dashboard'),
            array('/admin/web/message/list'),
            array('/admin/web/message/1/show'),
            array('/admin/web/message/1/answer'),
            array('/admin/web/category/list'),
            array('/admin/web/category/create'),
            array('/admin/web/category/1/show'),
            array('/admin/web/category/1/edit'),
            array('/admin/web/category/1/delete'),
            array('/admin/web/film/list'),
            array('/admin/web/film/create'),
            array('/admin/web/film/1/edit'),
            array('/admin/web/film/1/delete'),
            array('/admin/user/list'),
            array('/admin/user/create'),
            array('/admin/user/1/edit'),
            array('/admin/user/1/delete'),
        );
    }

    /**
     * Test HTTP request is not found
     *
     * @dataProvider provideNotFoundUrls
     * @param string $url
     */
    public function testAdminPagesAreNotFound($url)
    {
        $client = $this->makeClient(true);         // authenticated user
        $client->request('GET', $url);

        $this->assertStatusCode(404, $client);
    }

    /**
     * Not found Urls provider
     *
     * @return array
     */
    public function provideNotFoundUrls()
    {
        return array(
            array('/admin/web/message/create'),
            array('/admin/web/message/1/edit'),
            array('/admin/web/message/1/delete'),
            array('/admin/web/message/batch'),
            array('/admin/web/category/batch'),
            array('/admin/web/film/batch'),
            array('/admin/user/show'),
            array('/admin/user/batch'),
        );
    }
}
