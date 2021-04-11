<?php 

/* test response */
$router->get('/ping', [ 'as' => 'ping', function () use ($router) {
    return 'pong';
}]);

/* lumen version */
$router->get('/version', [ 'as' => 'version', function () use ($router) {
    return $router->app->version();
}]);