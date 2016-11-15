<?php

$app->get('/queue/add/{escapedUrlAddress}/{type}', function ($request, $response, $args) use ($app) {
    return (new \Controllers\AddToQueueController($app))->executeAction($request, $response);
});

$app->post('/queue/add', function ($request, $response, $args) use ($app) {
    return (new \Controllers\AddBatchToQueueController($app))->executeAction($request, $response);
});

$app->get('/queue/flush', function ($request, $response, $args) use ($app) {
    return (new \Controllers\FlushQueueController($app))->executeAction($request, $response);
});

$app->get('/jobs/process-queue', function ($request, $response, $args) use ($app) {
    return (new \Controllers\ProcessQueueJobController($app))->executeAction($request, $response);
});

$app->get('/', function ($request, $response, $args) use ($app) {
    return (new \Controllers\HomePageController($app))->executeAction($request, $response);
});

$app->get('/monitor/queue', function ($request, $response, $args) use ($app) {
    return (new \Controllers\MonitorQueueController($app))->executeAction($request, $response);
});
