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
    $router->get('/images/{id_word}', ['uses' => 'ImagesController@getImage', 'as' => 'getImage']); // Getting image with keyword
    $router->group(['middleware' => 'auth'], function () use ($router){
        $router->post('/images', ['uses' => 'ImagesController@upload', 'as' => 'uploadImage']);
        $router->put('/images/{id_image}/{id_word}', ['uses' => 'ImagesController@changeImage', 'as' => 'changeImage']); // Spare exist image with exist keyword
        $router->delete('/images/{id}', ['uses' => 'ImagesController@delete', 'as' => 'deleteImage']);

        $router->post('/keyword/{image_id}', ['uses' => 'WordController@addKeywordToImage', 'as' => 'addKeywordToImage']); //Adding keyword for image
    });

    //Words routes
    $router->post('/keyword', ['uses' => 'WordController@addKeyword', 'as' => 'addKeyword']); // Adding new keyword
    $router->get('/keyword', ['uses' => 'WordController@showKeyword', 'as' => 'showKeyword']);

    $router->post('/add_category', ['uses' => 'ImagesController@addCategory', 'as' => 'addCategory']); // Adding new category

});
