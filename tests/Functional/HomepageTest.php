<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /**
     * Test what happens if we just enter main page without passing a token
     */
    public function testHomePageWithoutToken()
    {
        $response = $this->runApp('GET', '/');

        $this->assertContains('Ouh, sorry, the \"_token\" field does not contain a valid value', (string)$response->getBody());
    }

    /**
     * And with token
     */
    public function testWithToken()
    {
        $response = $this->runApp('GET', '/?_token=this-is-an-example-of-api-token');

        $this->assertContains('Pong. Good morning Comrade, how are you? Do you have some URLs to check?', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}