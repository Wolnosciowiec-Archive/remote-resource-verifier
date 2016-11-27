<?php

namespace Tests\TypeHandlers;

use Monolog\Handler\HandlerInterface;
use TypeHandlers\UrlHandler;

/**
 * @package Tests\TypeHandlers
 */
class UrlHandlerTest extends BaseTypeHandlerTest
{
    protected function getHandlerInstance()
    {
        return new UrlHandler();
    }

    public function provideUrls(): array
    {
        return [
            'valid' => [
                'https://www.github.com/Wolnosciowiec',
                true,
            ],

            'other valid' => [
                'http://wolnosciowiec.net',
                true,
            ],

            'not valid' => [
                'ftp://wolnosciowiec.net',
                false,
            ],
        ];
    }

    /**
     * @return array
     */
    public function provideValidationLinks(): array
    {
        return [
            'valid' => ['http://wolnosciowiec.net', true],
            'not valid' => ['http://wolnosciowiec.net/this-url-does-not-exists.php', false],
        ];
    }
}