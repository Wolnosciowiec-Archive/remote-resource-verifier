<?php

$app->get('/queue/add/{escapedUrlAddress}/{type}', function ($request, $response, $args) use ($app) {
    return (new \Controllers\AddToQueueController($app))->executeAction($request, $response);
});

$app->get('/', function ($request, $response, $args) use ($app) {
    return (new \Controllers\HomePageController($app))->executeAction($request, $response);
});
