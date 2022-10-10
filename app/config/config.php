<?php

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'controllersDir' => APP_PATH . "/controllers/",
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'baseUri'        => '/',
    ],
    'api' => [
        'exchangeRate'      => [
            'url' => "https://v6.exchangerate-api.com/v6",
            'key' => "1e6c5b31c00e8ab77e7cef95",
            ]
    ],
    'cache' => [
        'keep_time_min' => 5*60
    ],
    'currencies' => [ "EUR", "GBP", "JPY", "CHF", "CAD", "AUD", "CNY", "ZAR", "BRL", "HKD", "MXN"]
]);
