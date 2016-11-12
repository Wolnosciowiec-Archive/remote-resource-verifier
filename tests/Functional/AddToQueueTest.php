<?php

namespace Tests\Functional;

/**
 * Adding to queue
 *
 * @package Tests\Functional
 */
class AddToQueueTest extends BaseTestCase
{
    public function testAddingValidElement()
    {
        $this->eraseDatabase();
        $response = $this->runApp('GET', '/queue/add/aHR0cDovL2NpYS5tZWRpYS5wbC90aGVtZXMvYm91cmdlb2lzL2d3aWF6ZGthX3NtYWxsLnBuZw==/image?_token=this-is-an-example-of-api-token');

        $this->assertContains('addToQueue:added', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @depends testAddingValidElement
     */
    public function testElementAlreadyExists()
    {
        $response = $this->runApp('GET', '/queue/add/aHR0cDovL2NpYS5tZWRpYS5wbC90aGVtZXMvYm91cmdlb2lzL2d3aWF6ZGthX3NtYWxsLnBuZw==/image?_token=this-is-an-example-of-api-token');
        $this->assertContains('addToQueue:url.already.exists', (string)$response->getBody());
    }
}