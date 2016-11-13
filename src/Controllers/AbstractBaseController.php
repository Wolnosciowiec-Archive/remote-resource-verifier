<?php

namespace Controllers;
use Factories\QueueItemFactory;
use JMS\Serializer\Serializer;
use Repositories\QueueRepository;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

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
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->repository = $app->getContainer()->get('repository.queue_item');
        $this->factory    = $app->getContainer()->get('factory.queue_item');
        $this->serializer = $app->getContainer()->get('serializer');
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

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    abstract public function executeAction(Request $request, Response $response);

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }
}