<?php

namespace Controllers;

use Entities\QueueItem;
use Exceptions\QueueItemException;
use Exceptions\UnsupportedHandlerException;
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
            $this->getLogger()->debug('Already exists in the queue "' . $url . '"');

            $response->withJson([
                'success' => true,
                'code'    => self::ADD_TO_QUEUE_URL_EXISTS_ALREADY,
            ], 301);

            return $response;
        }

        try {
            $queueItem = $this->getFactory()->createNewQueueItem($url, ucfirst($request->getAttribute('type')));
            $this->getRepository()->save($queueItem);
            $this->getLogger()->debug('AddToQueue catch "' . $url . '"');
        }

        catch (QueueItemException $e) {
            $this->getLogger()->warning('Catched a QueueItemException "' . $e->getMessage() . '" for url "' . $url . '"');

            $response->withJson([
                'success' => false,
                'message' => $e->getMessage(),
                'type'    => get_class($e),
            ], 400);

            return $response;
        }

        // @todo: Refactor when PHP 7.1 will come out
        // catch (QueueItemException | UnsupportedHandlerException $e) {
        catch (UnsupportedHandlerException $e) {
            $this->getLogger()->warning('Catched a UnsupportedHandlerException "' . $e->getMessage() . '" for url "' . $url . '"');

            $response->withJson([
                'success' => false,
                'message' => $e->getMessage(),
                'type'    => get_class($e),
            ], 400);

            return $response;
        }

        $this->getLogger()->debug('AddToQueue success for "' . $url . '"');
        $response->withJson([
            'success' => true,
            'code'    => self::ADDED_TO_QUEUE,
        ], 200);

        return $response;
    }
}