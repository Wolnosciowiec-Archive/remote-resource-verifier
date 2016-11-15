<?php

$settings = require __DIR__ . '/settings_prod.php';

$settings['settings']['displayErrorDetails'] = true;
$settings['debug'] = true;
$settings['apiToken'] = 'this-is-an-example-of-api-token';

if (is_file(__DIR__ . '/settings_dev.custom.php')) {
    $settings = array_merge($settings, require __DIR__ . '/settings_dev.custom.php');
}

return $settings;
