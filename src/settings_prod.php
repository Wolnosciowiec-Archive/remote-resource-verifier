<?php

$settings = [
    'settings' => [
        'debug'    => false,
        'apiToken' => (getenv('WUV_TOKEN') ? getenv('WUV_TOKEN') : 'this-is-an-example-of-api-token'),

        // process the resource only once, keep it in history to not allow adding it again
        'processOnlyOnce' => (getenv('WUV_PROCESS_ONLY_ONCE') ? (bool)getenv('WUV_PROCESS_ONLY_ONCE') : false),

        // limit to only X number of checks per one worker iteration eg. 16 checks per minute/request
        'processing.limitation' => (getenv('WUV_PROCESS_LIMITATION') ? (int)getenv('WUV_PROCESS_LIMITATION') : 16),

        'displayErrorDetails'    => (getenv('WUV_DISPLAY_ERRORS') ? (bool)getenv('WUV_DISPLAY_ERRORS') : false), // set to false in production
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

if (is_file(__DIR__ . '/settings_prod.custom.php')) {
    $settings = array_merge($settings, require __DIR__ . '/settings_prod.custom.php');
}

return $settings;
