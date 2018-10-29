<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'lugares'], function (Router $router) {

    $router->get('/', [
        'as' => 'iplaces.place.index',
        'uses' => 'PublicController@index',
    ]);
    $router->get('/{slugcategory}', [
        'as' => 'iplaces.place.category',
        'uses' => 'PublicController@category',
    ]);
    $router->get('{slugcategory}/{slugplace}', [
        'as' => 'iplaces.place.show',
        'uses' => 'PublicController@show',
    ]);

});

