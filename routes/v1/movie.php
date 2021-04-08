<?php 

/* movie group */
$router->group(['prefix' => 'movie', 'as' => 'movie'], function () use ($router) {

    /* all movies */
    $router->get('/all', [ 'as' => 'all', 'uses' => 'MovieController@all']);

    /* show movies by id */
    $router->get('/{id}', [ 'as' => 'show', 'uses' => 'MovieController@show']);

    /* restrict route */
    $router->group(['middleware' => 'auth'], function () use ($router) {

        /* movies viewed */
        $router->put('/{id}/viewed', [ 'as' => 'viewed', 'uses' => 'MovieController@viewed']);

        /* create movies */
        $router->post('/create', [ 'as' => 'create', 'uses' => 'MovieController@create']);
        
        /* update movies */
        $router->patch('/{id}/update', [ 'as' => 'update', 'uses' => 'MovieController@update']);

        /* delete movies */
        $router->delete('/{id}/delete', [ 'as' => 'delete', 'uses' => 'MovieController@delete']);
    
    });

    
});
