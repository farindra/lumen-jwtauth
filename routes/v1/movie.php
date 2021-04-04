<?php 

/* movie group */
$router->group(['prefix' => 'v1'], function () use ($router) {

    /* movie route name */
    $router->name('movies.')->group(function () use ($router) {

        /* all movies */
        $router->get('/', 'MovieController@index')->name('index');

        /* show movies by id */
        $router->get('/{id}', 'MovieController@store')->name('show');

        /* create movies */
        $router->post('/create', 'MovieController@store')->name('create');
        
        /* update movies */
        $router->patch('/{id}/update', 'MovieController@store')->name('update');

        /* delete movies */
        $router->delete('/{id}/delete', 'MovieController@delete')->name('delete');

    });
    
});
