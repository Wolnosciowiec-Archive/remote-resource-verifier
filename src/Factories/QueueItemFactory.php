<?php declare(strict_types=1);

namespace Factories;

use Entities\QueueItem;
use Exceptions\QueueItemException;

/**
 * @package Factories
 */
class QueueItemFactory
{
    /**
     * @var TypeHandlerFactory $typeHandlerFactory
     */
    private $typeHandlerFactory;

    public function __construct(TypeHandlerFactory $typeHandlerFactory)
    {
        $this->typeHandlerFactory = $typeHandlerFactory;
    }

    /**
     * @param string $url
     * @param string $type
     *
     * @throws QueueItemException
     * @return QueueItem
     */
    public function createNewQueueItem($url, string $type = 'Url')
    {
        $item = new QueueItem();
        $item->setDateAdded(new \DateTime('now'));
        $item->setState(QueueItem::STATE_QUEUED);
        $item->setUrlAddress($url);
        $item->setType($type);

        if (!$this->typeHandlerFactory->getTypeHandler($type)->isAbleToHandle($url)) {
            throw new QueueItemException('Selected handler "' . $type . '" is not able to handle the url "' . $url . '"');
        }

        return $item;
    }
}