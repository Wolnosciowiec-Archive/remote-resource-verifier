<?php

namespace Controllers;
use Factories\QueueItemFactory;
use Repositories\QueueRepository;
use Slim\App;

/**
 * @package Controllers
 */
abstract class AbstractBaseController
{
    /**
     * @var QueueRepository $repository
     */
    private $repository;

    /**
     * @var QueueItemFactory
     */
    private $factory;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->repository = $app->getContainer()->get('repository.queue_item');
        $this->factory    = $app->getContainer()->get('factory.queue_item');
    }

    /**
     * @return QueueRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return QueueItemFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}