<?php
return [
    'settings' => [
        'apiToken' => 'this-is-an-example-of-api-token',

        // process the resource only once, keep it in history to not allow adding it again
        'processOnlyOnce' => false,

        // limit to only X number of checks per one worker iteration eg. 16 checks per minute/request
        'processing.limitation' => 16,

        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => true, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'remote-resource-verifier',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
