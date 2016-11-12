<?php

namespace Factories;

use Exceptions\TypeHandlerException;
use Exceptions\UnsupportedHandlerException;
use Slim\Container;
use Slim\Exception\ContainerValueNotFoundException;
use TypeHandlers\TypeHandlerInterface;

class TypeHandlerFactory
{
    /**
     * @var Container $container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Constructs a type handler
     *
     * @param string $handlerName
     *
     * @throws UnsupportedHandlerException
     * @return TypeHandlerInterface
     */
    public function getTypeHandler(string $handlerName)
    {
        try {
            return $this->container->get('handler.' . $handlerName);
        }
        catch (ContainerValueNotFoundException $e) {
            throw new UnsupportedHandlerException('Handler "' . $handlerName . '" is not supported"');
        }
    }
}