<?php

namespace Controllers;

use Entities\QueueItem;
use Factories\TypeHandlerFactory;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * A worker job that is processing the queue
 *
 * @package Controllers
 */
class ProcessQueueJobController extends AbstractBaseController
{
    /**
     * @return TypeHandlerFactory
     */
    private function getHandlerFactory()
    {
        return $this->getContainer()->get('factory.type_handler');
    }

    /**
     * @return int
     */
    private function getLimitation()
    {
        return (int)$this->getContainer()->get('settings')['processing.limitation'];
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @throws \Exceptions\UnsupportedHandlerException
     * @return Response
     */
    public function executeAction(Request $request, Response $response)
    {
        $processedCount = 0;
        $queued         = $this->getRepository()->findByState([
            QueueItem::STATE_QUEUED,
        ]);

        $handlerFactory = $this->getHandlerFactory();

        foreach ($queued as $queueItem) {
            $processedCount++;
            $handler = $handlerFactory->getTypeHandler(
                $queueItem->getType()
            );

            $newState = $handler->isValid($queueItem->getUrlAddress())
                ? QueueItem::STATE_PROCESSED : QueueItem::STATE_FAILED;

            $queueItem->setState($newState);
            $this->getRepository()->save($queueItem);

            if ($this->getLimitation() !== 0
                && $processedCount >= $this->getLimitation()) {
                break;
            }
        }

        return $response->withJson([
            'success' => true,
            'processed_count' => $processedCount,
        ]);
    }
}