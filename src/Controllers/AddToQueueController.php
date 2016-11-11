<?php

namespace Controllers;
use Entities\QueueItem;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Stores the URL in the queue
 *
 * @package Controllers
 */
class AddToQueueController extends AbstractBaseController
{
    const ADD_TO_QUEUE_URL_EXISTS_ALREADY = 'addToQueue:url.already.exists';
    const ADDED_TO_QUEUE                  = 'addToQueue:added';

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function executeAction(Request $request, Response $response)
    {
        $url = base64_decode($request->getAttribute('escapedUrlAddress'));
        $existingUrl = $this->getRepository()->findOneByUrl($url);

        if ($existingUrl instanceof QueueItem) {
            $response->withJson([
                'success' => true,
                'code'    => self::ADD_TO_QUEUE_URL_EXISTS_ALREADY,
            ], 301);
            return $response;
        }

        $queueItem = $this->getFactory()->createNewQueueItem($url);
        var_dump($queueItem);
        $this->getRepository()->save($queueItem);

        $response->withJson([
            'success' => true,
            'code'    => self::ADDED_TO_QUEUE,
        ], 200);

        return $response;
    }
}