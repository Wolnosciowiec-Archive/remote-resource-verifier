<?php

namespace Controllers;

use Entities\QueueItem;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Returns a list of all processed items from the queue
 * and removes them from the queue
 *
 * @package Controllers
 */
class FlushQueueController extends AbstractBaseController
{
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function executeAction(Request $request, Response $response)
    {
        $processed = $this->getRepository()->findByState([
            QueueItem::STATE_PROCESSED,
            QueueItem::STATE_FAILED,
        ]);

        $responseSerialized = $this->getSerializer()->serialize([
            'success'   => true,
            'processed' => $processed,
            'legend'    => [
                'processed' => 'Still valid',
                'failed'    => 'No longer valid',
            ]
        ], 'json');

        // passing flush_only=1 to the query string allows for testing the response handling
        // without touching the data in the queue
        if ($request->getParam('get_only') != '1') {
            $this->getRepository()->flushState($processed);
        }

        return $response->write($responseSerialized);
    }
}