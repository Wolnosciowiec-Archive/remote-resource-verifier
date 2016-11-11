<?php
// Routes

$app->get('/queue/add/{escapedUrlAddress}/{type}', function ($request, $response, $args) use ($app) {
    return (new \Controllers\AddToQueueController($app))->executeAction($request, $response);
});
