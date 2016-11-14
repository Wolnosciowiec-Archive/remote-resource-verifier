<?php

namespace Repositories;

use Entities\QueueItem;

/**
 * @package Repositories
 */
class QueueRepository extends AbstractBaseRepository
{
    /**
     * @return bool
     */
    protected function isProcessingOnlyOnce()
    {
        return (bool)($this->settings['processOnlyOnce'] ?? false);
    }

    /**
     * @param array|string $state
     * @return QueueItem[]
     */
    public function findByState($state)
    {
        return $this->getDb()->mapper(QueueItem::class)
            ->where([
                'state' => $state,
            ])->execute()->entities();
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
     * @throws \InvalidArgumentException
     */
    public function save($entity)
    {
        if (!$entity instanceof QueueItem) {
            throw new \InvalidArgumentException('Input entity must be an instanceof QueueItem');
        }

        $entity->update();

        if ($entity->getId() > 0) {
            $this->getDb()->mapper(QueueItem::class)->update($entity);
            return;
        }

        $this->getDb()->mapper(QueueItem::class)
            ->save($entity, ['validate' => false]);
    }

    /**
     * @param QueueItem $entity
     */
    public function delete($entity)
    {
        $this->getDb()->mapper(QueueItem::class)
            ->delete([
                'id' => $entity->getId(),
            ]);
    }

    /**
     * @param QueueItem[] $entities
     */
    public function flushState(array $entities)
    {
        foreach ($entities as $queueItem) {

            if ($this->isProcessingOnlyOnce()) {
                $this->delete($queueItem);
                continue;
            }

            $newState = $queueItem->getState() === QueueItem::STATE_PROCESSED
                ? QueueItem::STATE_HISTORIC : QueueItem::STATE_HISTORIC_FAILED;

            $queueItem->setState($newState);
            $this->save($queueItem);
        }
    }
}