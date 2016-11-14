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
     * @var \Slim\Collection|array $settings
     */
    protected $settings;

    /**
     * @param Locator $db
     * @param \Slim\Collection $settings
     */
    public function __construct(Locator $db, \Slim\Collection $settings)
    {
        $this->db = $db;
        $this->settings = $settings;
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