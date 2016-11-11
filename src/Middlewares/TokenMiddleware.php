<?php

use Psr\Http\Message\ServerRequestInterface;

/**
 * @param \Slim\App $app
 *
 * @throws Exception
 * @return string
 */
function getConfiguredToken(\Slim\App $app)
{
    if (!isset($app->getContainer()->get('settings')['apiToken'])) {
        throw new \Exception('api_token is missing in the environment configuration');
    }

    if (getenv('API_TOKEN')) {
        return getenv('API_TOKEN');
    }

    return $app->getContainer()->get('settings')['apiToken'];
}

$app->add(function (ServerRequestInterface $request, Slim\Http\Response $response, callable $next) use ($app) {

    if (!isset($request->getQueryParams()['_token'])
        || getConfiguredToken($app) !== $request->getQueryParams()['_token']) {

        $response->withStatus(403)
            ->withJson([
                'success' => false,
                'code'    => 403,
                'message' => 'Ouh, sorry, the "_token" field does not contain a valid value'
            ]);

        return $response;
    }

    $response = $next($request, $response);
    return $response;
});