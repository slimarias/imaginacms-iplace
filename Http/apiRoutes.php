<?php

use Illuminate\Routing\Router;

$router->group(['prefix'=>'iplace'],function (Router $router){

    $router->group(['prefix' => 'places'], function (Router $router) {

        $router->bind('aiplacesplace', function ($id) {
            return app(\Modules\Iplaces\Repositories\PlaceRepository::class)->find($id);
        });
        $router->get('/', [
            'as' => 'iplace.api.places',
            'uses' => 'PlaceController@places',
        ]);
        $router->get('{aiplacesplace}', [
            'as' => 'iplace.api.place',
            'uses' => 'PlaceController@place',
        ]);
        $router->post('/', [
            'as' => 'iplace.api.places.store',
            'uses' => 'PlaceController@store',
            'middleware' => ['api.token','token-can:iplaces.places.create']
        ]);
        $router->post('gallery', [
            'as' => 'iplace.api.places.gallery.store',
            'uses' => 'PlaceController@galleryStore',
            'middleware' => ['api.token','token-can:iplaces.places.create']
        ]);
        $router->post('gallery/delete', [
            'as' => 'iplace.api.places.gallery.delete',
            'uses' => 'PlaceController@galleryDelete',
            'middleware' => ['api.token','token-can:iplaces.places.create']
        ]);
        $router->put('{aiplacesplace}', [
            'as' => 'iplace.api.places.update',
            'uses' => 'PlaceController@update',
            'middleware' =>['api.token','token-can:iplaces.places.edit']
        ]);
        $router->delete('{aiplacesplace}', [
            'as' => 'iplace.api.places.delete',
            'uses' => 'PlaceController@delete',
            'middleware' => ['api.token','token-can:iplaces.places.destroy']
        ]);
    });
    $router->group(['prefix' => 'categories'], function (Router $router) {

        $router->bind('aiplacescat', function ($id) {

           return app(\Modules\Iplaces\Repositories\CategoryRepository::class)->find($id);
        });
        $router->get('/', [
            'as' => 'iplace.api.categories',
            'uses' => 'CategoryController@categories',
        ]);
        $router->get('{aiplacescat}', [
            'as' => 'iplace.api.category',
            'uses' => 'CategoryController@category',
        ]);
        $router->get('{aiplacescat}/places', [
            'as' => 'iplace.api.categories.places',
            'uses' => 'CategoryController@places',
        ]);
        $router->post('/', [
            'as' => 'iplace.api.categories.store',
            'uses' => 'CategoryController@store',
            'middleware' => ['api.token','token-can:iplaces.categories.create']
        ]);
        $router->put('{aiplacescat}', [
            'as' => 'iplace.api.categories.update',
            'uses' => 'CategoryController@update',
            'middleware' =>['api.token','token-can:iplaces.categories.edit']
        ]);
        $router->delete('{aiplacescat}', [
            'as' => 'iplace.api.categories.delete',
            'uses' => 'CategoryController@delete',
            'middleware' => ['api.token','token-can:iplaces.categories.destroy']
        ]);
    });
    

});
