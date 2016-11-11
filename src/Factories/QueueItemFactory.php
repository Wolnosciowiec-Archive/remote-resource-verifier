<?php

namespace Factories;

use Entities\QueueItem;

/**
 * @package Factories
 */
class QueueItemFactory
{
    /**
     * @param string $url
     * @return QueueItem
     */
    public function createNewQueueItem($url)
    {
        $item = new QueueItem();
        $item->setDateAdded(new \DateTime('now'));
        $item->setState(QueueItem::STATE_QUEUED);
        $item->setUrlAddress($url);

        return $item;
    }
}