<?php 

/* registration */
$router->post('/register', [ 'as' => 'register', 'uses' => 'AuthController@register']);

/* login */
$router->post('/login', [ 'as' => 'login', 'uses' => 'AuthController@login']);

/* restrict route */
$router->group(['middleware' => 'auth'], function () use ($router) {
    
    /* get user profile */
    $router->get('/profile',    [ 'as' => 'profile', 'uses' => 'AuthController@profile']);
   
});