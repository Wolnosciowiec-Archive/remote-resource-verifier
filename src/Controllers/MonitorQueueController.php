<?php

namespace Controllers;
use Entities\QueueItem;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Displays a simple web panel
 * for monitoring purposes
 *
 * @package Controllers
 */
class MonitorQueueController extends AbstractBaseController
{
    public function executeAction(Request $request, Response $response)
    {
        $queueItems = $this->getRepository()->findByState([
            QueueItem::STATE_QUEUED,
            QueueItem::STATE_PROCESSED,
            QueueItem::STATE_FAILED,
        ]);

        return $this->getRenderer()->render($response, 'MonitorQueue.html.twig', [
            'queueItems' => $queueItems,
        ]);
    }
}