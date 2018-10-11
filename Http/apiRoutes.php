<?php

use Illuminate\Routing\Router;

$router->group(['prefix'=>'iplace'],function (Router $router){

    $router->group(['prefix' => 'places'], function (Router $router) {

        $router->bind('entity', function ($id) {
            return app(\Modules\Iplace\Repositories\PlaceRepository::class)->find($id);
        });
        $router->get('/', [
            'as' => 'iplace.api.places',
            'uses' => 'PlaceController@places',
        ]);
        $router->get('{entity}', [
            'as' => 'iplace.api.place',
            'uses' => 'PlaceController@place',
        ]);
        $router->post('/', [
            'as' => 'iplace.api.places.store',
            'uses' => 'PlaceController@store',
            'middleware' => ['api.token','token-can:iplace.places.create']
        ]);
        $router->post('gallery', [
            'as' => 'iplace.api.places.gallery.store',
            'uses' => 'PlaceController@galleryStore',
            'middleware' => ['api.token','token-can:iplace.places.create']
        ]);
        $router->post('gallery/delete', [
            'as' => 'iplace.api.places.gallery.delete',
            'uses' => 'PlaceController@galleryDelete',
            'middleware' => ['api.token','token-can:iplace.places.create']
        ]);
        $router->put('{entity}', [
            'as' => 'iplace.api.places.update',
            'uses' => 'PlaceController@update',
            'middleware' =>['api.token','token-can:iplace.places.edit']
        ]);
        $router->delete('{entity}', [
            'as' => 'iplace.api.places.delete',
            'uses' => 'PlaceController@delete',
            'middleware' => ['api.token','token-can:iplace.places.destroy']
        ]);
    });
    $router->group(['prefix' => 'categories'], function (Router $router) {

        $router->bind('cat', function ($id) {
            return app(\Modules\Iplace\Repositories\CategoryRepository::class)->find($id);
        });
        $router->get('/', [
            'as' => 'iplace.api.categories',
            'uses' => 'CategoryController@categories',
        ]);
        $router->get('{cat}', [
            'as' => 'iplace.api.category',
            'uses' => 'CategoryController@category',
        ]);
        $router->get('{cat}/places', [
            'as' => 'iplace.api.categories.places',
            'uses' => 'CategoryController@places',
        ]);
        $router->post('/', [
            'as' => 'iplace.api.categories.store',
            'uses' => 'CategoryController@store',
            'middleware' => ['api.token','token-can:iplace.categories.create']
        ]);
        $router->put('{cat}', [
            'as' => 'iplace.api.categories.update',
            'uses' => 'CategoryController@update',
            'middleware' =>['api.token','token-can:iplace.categories.edit']
        ]);
        $router->delete('{cat}', [
            'as' => 'iplace.api.categories.delete',
            'uses' => 'CategoryController@delete',
            'middleware' => ['api.token','token-can:iplace.categories.destroy']
        ]);
    });
    

});
