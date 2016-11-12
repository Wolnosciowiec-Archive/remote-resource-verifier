<?php

namespace TypeHandlers;

use Slim\Http\Stream;

/**
 * Verifies if the remote resource is a image
 *
 * @package TypeHandlers
 */
class ImageHandler extends UrlHandler implements TypeHandlerInterface
{
    /**
     * @return array
     */
    protected function getMimeTypes()
    {
        return [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/x-icon',
            'image/pjpeg',
            'image/tiff',
            'image/x-tiff',
            'image/svg+xml',
        ];
    }

    /**
     * @inheritdoc
     */
    public function isValid(string $url) : bool
    {
        $stream = new Stream(@fopen($url, 'r'));
        $firstBytes = $stream->read(512);

        if (strlen($firstBytes) === 0) {
            return false;
        }

        $mime = (new \finfo(FILEINFO_MIME))->buffer($firstBytes);
        $parts = explode(';', (string)$mime);

        if (strlen($parts[0]) === 0) {
            return false;
        }

        return in_array($parts[0], $this->getMimeTypes());
    }
}