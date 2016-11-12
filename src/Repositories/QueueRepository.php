<?php

namespace Repositories;

use Entities\QueueItem;

/**
 * @package Repositories
 */
class QueueRepository extends AbstractBaseRepository
{
    /**
     * @param $state
     * @return QueueItem[]|\Spot\Query
     */
    public function findByState(string $state)
    {
        return $this->getDb()->mapper(QueueItem::class)
            ->all()->where([
                'state' => $state,
            ]);
    }

    /**
     * @param string $url
     * @return QueueItem
     */
    public function findOneByUrl(string $url)
    {
        return $this->getDb()->mapper(QueueItem::class)
            ->first([
                'urlAddress' => $url,
            ]);
    }

    /**
     * @param QueueItem $entity
     */
    public function save($entity)
    {
        $this->getDb()->mapper(QueueItem::class)
            ->save($entity);
    }
}