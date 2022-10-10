<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';


    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    require APP_PATH .  '/config/routes.php';

    $app->after(
        function () use ($app) {
            // Getting the return value of method
            $return = $app->getReturnedValue();
            if ($return) {
                // Transforming arrays to JSON
                $app->response->setContent(json_encode($return));
            } elseif (empty($return) || !strlen($return)) {
                // Successful response without any content
                $app->response->setStatusCode(204, 'No Content');
            } else {
                // Unexpected response
                throw new Exception('Bad Response');
            }

            // Sending response to the client
            $app->response->send();
        }
    );
    /**
     * Include Application
     */
    include APP_PATH . '/app.php';

    /**
     * Handle the request
     */
    $app->handle($_SERVER['REQUEST_URI']);
} catch (AbstractHttpException $e) {
    $response = $app->response;
    $response->setStatusCode($e->getCode(), $e->getMessage());
    $response->setJsonContent($e->getAppError());
    $response->send();
} catch (\Phalcon\Http\Request\Exception $e) {
    $app->response->setStatusCode(400, 'Bad request')
        ->setJsonContent([
            AbstractHttpException::KEY_CODE    => 400,
            AbstractHttpException::KEY_MESSAGE => 'Bad request'
        ])
        ->send();
} catch (\Exception $e) {
    // Standard error format
    $result = [
        AbstractHttpException::KEY_CODE    => 500,
        AbstractHttpException::KEY_MESSAGE => 'Some error occurred on the server.'
    ];

//    Sending error response
    $app->response->setStatusCode(500, 'Internal Server Error')
        ->setJsonContent($result)
        ->send();

    // @TODO remove below lines
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}