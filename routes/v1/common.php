<?php 

/* test response */
$router->get('/ping', function () {
    return 'pong';
});