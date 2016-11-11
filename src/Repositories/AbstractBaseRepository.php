<?php

namespace Repositories;

use Spot\Locator;

/**
 * @package Repositories
 */
abstract class AbstractBaseRepository
{
    /**
     * @var Locator $db
     */
    private $db;

    /**
     * @param Locator $db
     */
    public function __construct(Locator $db)
    {
        $this->db = $db;
    }

    /**
     * @return Locator
     */
    public function getDb()
    {
        return $this->db;
    }

    abstract public function save($entity);
}