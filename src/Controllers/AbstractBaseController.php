<?php

namespace Controllers;
use Factories\QueueItemFactory;
use JMS\Serializer\Serializer;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Repositories\QueueRepository;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @package Controllers
 */
abstract class AbstractBaseController
{
    const ERROR_REQUEST_INVALID = 'REQUEST_VALIDATION_FAILED';

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
     * @var \Interop\Container\ContainerInterface
     */
    private $container;

    /**
     * @var LoggerInterface $logging
     */
    private $logger;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->repository = $app->getContainer()->get('repository.queue_item');
        $this->factory    = $app->getContainer()->get('factory.queue_item');
        $this->serializer = $app->getContainer()->get('serializer');
        $this->container  = $app->getContainer();
        $this->logger     = $app->getContainer()->get('logger');
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

    /**
     * @return \Interop\Container\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}