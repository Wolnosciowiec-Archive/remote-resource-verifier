<?php

namespace Entities;

use Spot\Entity;

/**
 * @package Entities
 */
class QueueItem extends Entity
{
    const STATE_QUEUED = 'queued';
    const STATE_PROCESSED = 'processed';

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $urlAddress
     */
    protected $urlAddress;

    /**
     * @var \DateTime $dateAdded
     */
    protected $dateAdded;

    /**
     * @var string $state
     */
    protected $state;

    protected static $table = 'wuv_queue_items';

    /**
     * @return array
     */
    public static function fields()
    {
        return [
            'id'         => ['type' => 'integer', 'length' => 10, 'autoincrement' => true, 'primary' => true],
            'urlAddress' => ['type' => 'string', 'length' => 254, 'required' => true, 'unique' => true, 'index' => true],
            'state'      => ['type' => 'string', 'length' => 16, 'required' => true, 'unique' => true, 'index' => true],
            'dateAdded'  => ['type' => 'datetime', 'required' => true, 'value' => new \DateTime()],
        ];
    }

    /**
     * @param string|\DateTime $dateAdded
     * @return QueueItem
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded instanceof \DateTime ? $dateAdded : new \DateTime($dateAdded);
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param int $id
     * @return QueueItem
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $state
     * @return QueueItem
     */
    public function setState($state)
    {
        if (!in_array($state, [self::STATE_PROCESSED, self::STATE_QUEUED])) {
            throw new \InvalidArgumentException('Invalid object state selected');
        }

        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $urlAddress
     * @return QueueItem
     */
    public function setUrlAddress($urlAddress)
    {
        $this->urlAddress = $urlAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlAddress()
    {
        return $this->urlAddress;
    }
}