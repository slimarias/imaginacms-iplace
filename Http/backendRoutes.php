<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/places'], function (Router $router) {
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
       // dd('hjh'),
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

    $router->group(['prefix' => '/categories'], function (Router $router) {

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
    $router->bind('service', function ($id) {
        return app('Modules\Iplaces\Repositories\ServiceRepository')->find($id);
    });
    $router->get('services', [
        'as' => 'admin.iplaces.service.index',
        'uses' => 'ServiceController@index',
        'middleware' => 'can:iplaces.services.index'
    ]);
    $router->get('services/create', [
        'as' => 'admin.iplaces.service.create',
        'uses' => 'ServiceController@create',
        'middleware' => 'can:iplaces.services.create'
    ]);
    $router->post('services', [
        'as' => 'admin.iplaces.service.store',
        'uses' => 'ServiceController@store',
        'middleware' => 'can:iplaces.services.create'
    ]);
    $router->get('services/{service}/edit', [
        'as' => 'admin.iplaces.service.edit',
        'uses' => 'ServiceController@edit',
        'middleware' => 'can:iplaces.services.edit'
    ]);
    $router->put('services/{service}', [
        'as' => 'admin.iplaces.service.update',
        'uses' => 'ServiceController@update',
        'middleware' => 'can:iplaces.services.edit'
    ]);
    $router->delete('services/{service}', [
        'as' => 'admin.iplaces.service.destroy',
        'uses' => 'ServiceController@destroy',
        'middleware' => 'can:iplaces.services.destroy'
    ]);
    $router->bind('zone', function ($id) {
        return app('Modules\Iplaces\Repositories\ZoneRepository')->find($id);
    });
    $router->get('zones', [
        'as' => 'admin.iplaces.zone.index',
        'uses' => 'ZoneController@index',
        'middleware' => 'can:iplaces.zones.index'
    ]);
    $router->get('zones/create', [
        'as' => 'admin.iplaces.zone.create',
        'uses' => 'ZoneController@create',
        'middleware' => 'can:iplaces.zones.create'
    ]);
    $router->post('zones', [
        'as' => 'admin.iplaces.zone.store',
        'uses' => 'ZoneController@store',
        'middleware' => 'can:iplaces.zones.create'
    ]);
    $router->get('zones/{zone}/edit', [
        'as' => 'admin.iplaces.zone.edit',
        'uses' => 'ZoneController@edit',
        'middleware' => 'can:iplaces.zones.edit'
    ]);
    $router->put('zones/{zone}', [
        'as' => 'admin.iplaces.zone.update',
        'uses' => 'ZoneController@update',
        'middleware' => 'can:iplaces.zones.edit'
    ]);
    $router->delete('zones/{zone}', [
        'as' => 'admin.iplaces.zone.destroy',
        'uses' => 'ZoneController@destroy',
        'middleware' => 'can:iplaces.zones.destroy'
    ]);
// append



    });
});
