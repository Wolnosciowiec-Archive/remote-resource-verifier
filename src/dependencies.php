<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Slim\App;

$container = $app->getContainer();

// view renderer
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../templates/', [
        'cache' => __DIR__ . '/../data/cache/view/',
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

// database (spot2 ORM)
$cfg = new \Spot\Config();
$cfg->addConnection('sqlite', [
    'path' => __DIR__ . '/../data/database_' . ENV . '.sqlite3',
    'driver' => 'pdo_sqlite',
]);

$container['spot'] = new \Spot\Locator($cfg);

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// serializer
$container['serializer'] = function (\Slim\Container $container) {

    AnnotationRegistry::registerLoader('class_exists');

    $reader = new \Doctrine\Common\Annotations\AnnotationReader();
    $reader->addGlobalIgnoredName('returns');

    return JMS\Serializer\SerializerBuilder::create()
        ->addMetadataDir(__DIR__ . '/Resources/Serializer/')
        ->setCacheDir(__DIR__. '/../data/cache/serializer/')
        ->setDebug(true)
        ->setAnnotationReader($reader)
        ->build();
};

// repositories
$container['repository.queue_item'] = function (\Slim\Container $app) {
    /** @var \Spot\Locator $db */
    $db = $app['spot'];

    return new \Repositories\QueueRepository($db, $app->get('settings'));
};

// factories
$container['factory.type_handler'] = function (\Slim\Container $container) {
    return new Factories\TypeHandlerFactory($container);
};
$container['factory.queue_item'] = function (\Slim\Container $container) {
    return new Factories\QueueItemFactory($container->get('factory.type_handler'));
};

// type handlers
$container['handler.Url'] = function () { return new \TypeHandlers\UrlHandler(); };
$container['handler.Image'] = function () { return new \TypeHandlers\ImageHandler(); };