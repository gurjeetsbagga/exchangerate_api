<?php

$exchangeRateCollection = new \Phalcon\Mvc\Micro\Collection();
$exchangeRateCollection->setHandler('\App\Controllers\ExchangeRateController', true);
$exchangeRateCollection->setPrefix('/api');
$exchangeRateCollection->get('/exchange_rate/{rate:[a-zA-Z]*}', 'getExchangeRateAction');
$app->mount($exchangeRateCollection);

// not found URLs
$app->notFound(
    function () use ($app) {
        $exception =
            new \App\Controllers\HttpExceptions\Http404Exception(
                _('URI not found or error in request.'),
                \App\Controllers\AbstractController::ERROR_NOT_FOUND,
                new \Exception('URI not found: ' . $app->request->getMethod() . ' ' . $app->request->getURI())
            );
        throw $exception;
    }
);

$app->before(
    function () use ($app) {

        $origin = $app->request->getHeader("ORIGIN") ? $app->request->getHeader("ORIGIN") : '*';

        $app->response->setHeader("Access-Control-Allow-Origin", $origin)
            ->setHeader("Access-Control-Allow-Methods", 'GET,PUT,POST,DELETE,OPTIONS')
            ->setHeader("Access-Control-Allow-Headers", 'Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type, Authorization')
            ->setHeader("Access-Control-Allow-Credentials", true);
        $app->response->sendHeaders();

        return true;
    });
