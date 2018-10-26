<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'lugares'], function (Router $router) {

    $router->get('/', [
        'as' => 'iplaces.place.index',
        'uses' => 'PublicController@index',
        'middleware' => 'can:iplaces.places.index'
    ]);
    $router->get('/{category}', [
        'as' => 'iplaces.place.category',
        'uses' => 'PublicController@index',
    ]);
    $router->get('/{category}/{place}', [
        'as' => 'iplaces.place.show',
        'uses' => 'PublicController@show',
    ]);

});

