<?php 

/* registration */
$router->post('/register','AuthController@register');
$router->post('/login','AuthController@login');