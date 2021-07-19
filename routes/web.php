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
    $router->get('/', ['uses' => 'IndexController@index', 'as' => 'index']);

    //Auth routes
    $router->post('/login', ['uses' => 'AuthController@login', 'as' => 'login']); // done
    $router->post('/logout', ['uses' => 'AuthController@logout', 'as' => 'logout']); // done
    $router->post('/register', ['uses' => 'AuthController@register', 'as' => 'register']); // done

    //Images routes
    $router->get('/images', ['uses' => 'ImagesController@getImage', 'as' => 'getImage']); // not done
    $router->group(['middleware' => 'auth'], function () use ($router){
        $router->post('/images', ['uses' => 'ImagesController@upload', 'as' => 'upload']); // done
        $router->put('/images', ['uses' => 'ImagesController@change', 'as' => 'change']); //?
        $router->delete('/images[{id}]', ['uses' => 'ImagesController@delete', 'as' => 'delete']); // done
    });

    //Words routes
    $router->get('/keyword', ['uses' => 'WordController@keyword', 'as' => 'keyword']); // not done
});