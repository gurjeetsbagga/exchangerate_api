<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'App\Services'    => realpath(__DIR__ . '/../services/'),
        'App\Controllers' => realpath(__DIR__ . '/../controllers/'),
        'App\Helpers' => realpath(__DIR__ . '/../helpers/'),
    ]
)->register();