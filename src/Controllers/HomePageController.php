<?php

namespace Controllers;

use Entities\QueueItem;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @package Controllers
 */
class HomePageController extends AbstractBaseController
{
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function executeAction(Request $request, Response $response)
    {
        $response->withJson([
            'success' => true,
            'message' => 'Pong. Good morning Comrade, how are you? Do you have some URLs to check?',
            'version' => '1.0',
            'queue' => [
                'length' => [
                    'queued'    => $this->getRepository()->findByState(QueueItem::STATE_QUEUED)->count(),
                    'processed' => $this->getRepository()->findByState(QueueItem::STATE_PROCESSED)->count(),
                ]
            ],
        ]);

        return $response;
    }
}