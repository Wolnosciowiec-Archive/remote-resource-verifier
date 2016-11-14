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

    /**
     * Test batch adding to the queue
     */
    public function testAddingMultipleValidElements()
    {
        $this->eraseDatabase();

        $response = $this->runApp('POST', '/queue/add?_token=this-is-an-example-of-api-token', [
            'queue_data' => [
                [
                    'url_address' => 'https://raw.githubusercontent.com/blackandred/anarchist-images/master/12715514_10204353234189544_8319790892461323469_n.jpg',
                    'type'        => 'image',
                ],

                [
                    'url_address' => 'https://raw.githubusercontent.com/blackandred/anarchist-images/master/README.md',
                    'type'        => 'url',
                ],
            ]
        ]);

        $decoded = json_decode((string)$response->getBody(), true);

        $this->assertTrue($decoded['success']);
        $this->assertSame(2, $decoded['added_count']);
    }

    /**
     * Test batch adding to the queue
     */
    public function testAddingWithOneInvalidElement()
    {
        $this->eraseDatabase();

        $response = $this->runApp('POST', '/queue/add?_token=this-is-an-example-of-api-token', [
            'queue_data' => [
                [
                    'url_address' => 'https://raw.githubusercontent.com/blackandred/anarchist-images/master/12715514_10204353234189544_8319790892461323469_n.jpg',
                    'type'        => 'image',
                ],

                [
                    'url_address' => 'ftp://raw.githubusercontent.com/blackandred/anarchist-images/master/README.md',
                    'type'        => 'url',
                ],
            ]
        ]);

        $decoded = json_decode((string)$response->getBody(), true);
        $this->assertFalse($decoded['success']);
        $this->assertSame(1, $decoded['added_count']);
    }
}