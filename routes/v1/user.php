<?php 

/* registration */
$router->post('/register','AuthController@register');

/* login */
$router->post('/login','AuthController@login');


/* restrict route */
$router->group(['middleware' => 'auth'], function () use ($router) {
    
    /* get user profile */
    $router->get('/profile','AuthController@profile');
   
});