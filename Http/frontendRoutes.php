<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'Lugares'], function (Router $router) {

    $router->get('/', [
        'as' => 'admin.iplaces.place.index',
        'uses' => 'PublicController@index',
        'middleware' => 'can:iplaces.places.index'
    ]);
    $router->get('{category}', [
        'as' => 'admin.iplaces.place.index',
        'uses' => 'PublicController@index',
    ]);
    $router->get('{category}/{place}', [
        'as' => 'iplaces.place.show',
        'uses' => 'PublicController@show',
    ]);

});

