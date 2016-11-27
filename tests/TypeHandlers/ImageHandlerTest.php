<?php

namespace Tests\TypeHandlers;

use TypeHandlers\ImageHandler;

/**
 * @package Tests\TypeHandlers
 */
class ImageHandlerTest extends BaseTypeHandlerTest
{
    protected function getHandlerInstance()
    {
        return new ImageHandler();
    }

    /**
     * @return array
     */
    public function provideUrls(): array
    {
        return [
            'valid image' => [
                'https://raw.githubusercontent.com/blackandred/anarchist-images/master/10363902_882212875129512_66207955690022127_n.jpg',
                true,
            ],

            'text file' => [
                'https://raw.githubusercontent.com/blackandred/anarchist-images/master/README.md',
                true,
            ]
        ];
    }

    /**
     * @return array
     */
    public function provideValidationLinks(): array
    {
        return [
            'valid' => [
                'https://raw.githubusercontent.com/blackandred/anarchist-images/master/10363902_882212875129512_66207955690022127_n.jpg',
                true,
            ],
            'not valid' => [
                'https://raw.githubusercontent.com/blackandred/anarchist-images/master/README.md',
                false,
            ],
        ];
    }
}