<?php

use Slim\App;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
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

// repositories
$container['repository.queue_item'] = function (\Slim\Container $app) {
    /** @var \Spot\Locator $db */
    $db = $app['spot'];

    return new \Repositories\QueueRepository($db);
};

// factories
$container['factory.queue_item'] = function () {
    return new Factories\QueueItemFactory();
};
