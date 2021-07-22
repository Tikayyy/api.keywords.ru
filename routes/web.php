<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'api'], function () use ($router) {
    //Auth routes
    $router->post('/login', ['uses' => 'AuthController@login', 'as' => 'login']);
    $router->post('/logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);
    $router->post('/register', ['uses' => 'AuthController@register', 'as' => 'register']);

    //Images routes
    $router->get('/images/{id_word}', ['uses' => 'ImagesController@getImage', 'as' => 'getImage']);
    $router->group(['middleware' => 'auth'], function () use ($router){
        $router->post('/images', ['uses' => 'ImagesController@upload', 'as' => 'uploadImage']);
        $router->put('/images/{id_image}/{id_word}', ['uses' => 'ImagesController@changeImage', 'as' => 'changeImage']);
        $router->delete('/images/{id}', ['uses' => 'ImagesController@delete', 'as' => 'deleteImage']);
    });

    //Words routes
    $router->post('/keyword', ['uses' => 'WordController@addKeyword', 'as' => 'addKeyword']);
    $router->get('/keyword', ['uses' => 'WordController@showKeyword', 'as' => 'showKeyword']);
});
