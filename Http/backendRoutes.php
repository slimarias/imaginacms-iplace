<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'iplaces'], function (Router $router) {

    $router->group(['prefix' => 'places'], function (Router $router) {
        $router->bind('place', function ($id) {
            return app('Modules\Iplaces\Repositories\PlaceRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.place.index',
            'uses' => 'PlaceController@index',
            'middleware' => 'can:iplaces.places.index'
        ]);
        $router->get('create', [
           // dd('hgh'),
            'as' => 'admin.iplaces.place.create',
            'uses' => 'PlaceController@create',
            'middleware' => 'can:iplaces.places.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.place.store',
            'uses' => 'PlaceController@store',
            'middleware' => 'can:iplaces.places.create'
        ]);
        $router->get('{place}/edit', [
            'as' => 'admin.iplaces.place.edit',
            'uses' => 'PlaceController@edit',
            'middleware' => 'can:iplaces.places.edit'
        ]);
        $router->put('{place}', [
            'as' => 'admin.iplaces.place.update',
            'uses' => 'PlaceController@update',
            'middleware' => 'can:iplaces.places.edit'
        ]);
        $router->delete('{place}', [
            'as' => 'admin.iplaces.place.destroy',
            'uses' => 'PlaceController@destroy',
            'middleware' => 'can:iplaces.places.destroy'
        ]);
        $router->post('/{place_id}/addposts', [
            'as' => 'admin.ibusiness.userbusiness.addPosts',
            'uses' => 'PlaceController@addPosts'
        ]);
    });

    $router->group(['prefix' => 'categories'], function (Router $router) {
        $router->bind('category', function ($id) {
            return app('Modules\Iplaces\Repositories\CategoryRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.category.index',
            'uses' => 'CategoryController@index',
            'middleware' => 'can:iplaces.categories.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.category.create',
            'uses' => 'CategoryController@create',
            'middleware' => 'can:iplaces.categories.create'
        ]);
        $router->post('', [
            'as' => 'admin.iplaces.category.store',
            'uses' => 'CategoryController@store',
            'middleware' => 'can:iplaces.categories.create'
        ]);
        $router->get('{category}/edit', [
            'as' => 'admin.iplaces.category.edit',
            'uses' => 'CategoryController@edit',
            'middleware' => 'can:iplaces.categories.edit'
        ]);
        $router->put('{category}', [
            'as' => 'admin.iplaces.category.update',
            'uses' => 'CategoryController@update',
            'middleware' => 'can:iplaces.categories.edit'
        ]);
        $router->delete('{category}', [
            'as' => 'admin.iplaces.category.destroy',
            'uses' => 'CategoryController@destroy',
            'middleware' => 'can:iplaces.categories.destroy'
        ]);
    });

    $router->group(['prefix' => '/services'], function (Router $router) {

        $router->bind('service', function ($id) {
            return app('Modules\Iplaces\Repositories\ServiceRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.service.index',
            'uses' => 'ServiceController@index',
            'middleware' => 'can:iplaces.services.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.service.create',
            'uses' => 'ServiceController@create',
            'middleware' => 'can:iplaces.services.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.service.store',
            'uses' => 'ServiceController@store',
            'middleware' => 'can:iplaces.services.create'
        ]);
        $router->get('{service}/edit', [
            'as' => 'admin.iplaces.service.edit',
            'uses' => 'ServiceController@edit',
            'middleware' => 'can:iplaces.services.edit'
        ]);
        $router->put('{service}', [
            'as' => 'admin.iplaces.service.update',
            'uses' => 'ServiceController@update',
            'middleware' => 'can:iplaces.services.edit'
        ]);
        $router->delete('{service}', [
            'as' => 'admin.iplaces.service.destroy',
            'uses' => 'ServiceController@destroy',
            'middleware' => 'can:iplaces.services.destroy'
        ]);

    });

    $router->group(['prefix' => '/zones'], function (Router $router) {

        $router->bind('zone', function ($id) {
            return app('Modules\Iplaces\Repositories\ZoneRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.zone.index',
            'uses' => 'ZoneController@index',
            'middleware' => 'can:iplaces.zones.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.zone.create',
            'uses' => 'ZoneController@create',
            'middleware' => 'can:iplaces.zones.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.zone.store',
            'uses' => 'ZoneController@store',
            'middleware' => 'can:iplaces.zones.create'
        ]);
        $router->get('{zone}/edit', [
            'as' => 'admin.iplaces.zone.edit',
            'uses' => 'ZoneController@edit',
            'middleware' => 'can:iplaces.zones.edit'
        ]);
        $router->put('{zone}', [
            'as' => 'admin.iplaces.zone.update',
            'uses' => 'ZoneController@update',
            'middleware' => 'can:iplaces.zones.edit'
        ]);
        $router->delete('{zone}', [
            'as' => 'admin.iplaces.zone.destroy',
            'uses' => 'ZoneController@destroy',
            'middleware' => 'can:iplaces.zones.destroy'
        ]);
// append


    });

    $router->group(['prefix' => '/schedules'], function (Router $router) {

        $router->bind('schedule', function ($id) {
            return app('Modules\Iplaces\Repositories\ScheduleRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.schedule.index',
            'uses' => 'ScheduleController@index',
            'middleware' => 'can:iplaces.schedules.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.schedule.create',
            'uses' => 'ScheduleController@create',
            'middleware' => 'can:iplaces.schedules.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.schedule.store',
            'uses' => 'ScheduleController@store',
            'middleware' => 'can:iplaces.schedules.create'
        ]);
        $router->get('{schedule}/edit', [
            'as' => 'admin.iplaces.schedule.edit',
            'uses' => 'ScheduleController@edit',
            'middleware' => 'can:iplaces.schedules.edit'
        ]);
        $router->put('{schedule}', [
            'as' => 'admin.iplaces.schedule.update',
            'uses' => 'ScheduleController@update',
            'middleware' => 'can:iplaces.schedules.edit'
        ]);
        $router->delete('{schedule}', [
            'as' => 'admin.iplaces.schedule.destroy',
            'uses' => 'ScheduleController@destroy',
            'middleware' => 'can:iplaces.schedules.destroy'
        ]);
// append


    });
});

