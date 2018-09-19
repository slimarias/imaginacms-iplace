<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iplaces'], function (Router $router) {
    $router->bind('place', function ($id) {
        return app('Modules\Iplaces\Repositories\PlaceRepository')->find($id);
    });
    $router->get('places', [
        'as' => 'admin.iplaces.place.index',
        'uses' => 'PlaceController@index',
        'middleware' => 'can:iplaces.places.index'
    ]);
    $router->get('places/create', [
        'as' => 'admin.iplaces.place.create',
        'uses' => 'PlaceController@create',
        'middleware' => 'can:iplaces.places.create'
    ]);
    $router->post('places', [
        'as' => 'admin.iplaces.place.store',
        'uses' => 'PlaceController@store',
        'middleware' => 'can:iplaces.places.create'
    ]);
    $router->get('places/{place}/edit', [
        'as' => 'admin.iplaces.place.edit',
        'uses' => 'PlaceController@edit',
        'middleware' => 'can:iplaces.places.edit'
    ]);
    $router->put('places/{place}', [
        'as' => 'admin.iplaces.place.update',
        'uses' => 'PlaceController@update',
        'middleware' => 'can:iplaces.places.edit'
    ]);
    $router->delete('places/{place}', [
        'as' => 'admin.iplaces.place.destroy',
        'uses' => 'PlaceController@destroy',
        'middleware' => 'can:iplaces.places.destroy'
    ]);
    $router->bind('category', function ($id) {
        return app('Modules\Iplaces\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.iplaces.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:iplaces.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.iplaces.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:iplaces.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.iplaces.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:iplaces.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.iplaces.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:iplaces.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.iplaces.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:iplaces.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.iplaces.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:iplaces.categories.destroy'
    ]);
// append


});
