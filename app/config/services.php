<?php
declare(strict_types=1);

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Mvc\View\Simple as View;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Url as UrlResolver;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Override response content type
 */
$di->setShared(
    'response',
    function () {
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'utf-8');

        return $response;
    }
);

/**
 * Override response content type
 */
$di->setShared(
    'cache',
    function() {
        $serializerFactory = new SerializerFactory();
        $adapterFactory = new AdapterFactory($serializerFactory);
        $options = [
            'defaultSerializer' => 'Php',
            'lifetime' => 1
        ];
        $adapter = $adapterFactory->newInstance('apcu', $options);
        return new Cache($adapter);
    }
);
