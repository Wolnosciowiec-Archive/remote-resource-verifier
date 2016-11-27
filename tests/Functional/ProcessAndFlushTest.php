<?php

namespace Tests\Functional;

/**
 * @package Tests\Functional
 */
class ProcessAndFlushTest extends BaseTestCase
{
    /**
     * Test adding an item to the queue and then processing the queue
     */
    public function testProcessing()
    {
        $this->eraseDatabase();

        // add items to the queue
        $this->runApp('POST', '/queue/add?_token=this-is-an-example-of-api-token', [
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

        $response = json_decode((string)$this->runApp('GET', '/jobs/process-queue?_token=this-is-an-example-of-api-token')
            ->getBody(), true);

        $this->assertTrue($response['success']);
        $this->assertSame(2, $response['processed_count']);
    }

    /**
     * @depends testProcessing
     */
    public function testFlushingTheQueue()
    {
        $response = json_decode((string)$this->runApp('GET', '/queue/flush?_token=this-is-an-example-of-api-token')
            ->getBody(), true);

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['processed']);
    }
}