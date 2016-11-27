<?php

namespace TypeHandlers;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

/**
 * Handles remote URL verification
 * basing on HTTP status code
 *
 * @package TypeHandlers
 */
class UrlHandler implements TypeHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function isAbleToHandle(string $url) : bool
    {
        return in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https']);
    }

    /**
     * @inheritdoc
     */
    public function isValid(string $url) : bool
    {
        $client = new Client();

        try {
            $response = $client->head($url)->send();
        }
        catch (ClientErrorResponseException $e) {
            return false;
        }

        return $response->getStatusCode() === 200;
    }
}