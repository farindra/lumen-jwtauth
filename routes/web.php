<?php
use App\Libraries\Core;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/* v1 group */
$router->group(['prefix' => 'v1', 'as' => 'v1'], function () use ($router) {

    Core::renderRoutes('v1', $router);
    
});