<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EyeController;
use App\Http\Controllers\TransactionController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/customer/search','CustomerController@search');
$router->get('/customer','CustomerController@index');
$router->get('/customer/{id}','CustomerController@show');
$router->delete('/customer/{id}','CustomerController@delete');
$router->post('/customer','CustomerController@create');
$router->put('/customer/{id}','CustomerController@update');

$router->get('/eye/search','EyeController@search');
$router->get('/eye','EyeController@index');
$router->get('/eye/{id}','EyeController@show');
$router->delete('/eye/{id}','EyeController@delete');
$router->post('/eye','EyeController@create');
$router->put('/eye/{id}','EyeController@update');

$router->get('/eye/search','TransactionController@search');
$router->get('/eye','TransactionController@index');
$router->get('/eye/{id}','TransactionController@show');
$router->delete('/eye/{id}','TransactionController@delete');
$router->post('/eye','TransactionController@create');
$router->put('/eye/{id}','TransactionController@update');



Route::group([
    'prefix' => 'api'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user-profile', 'AuthController@me');
});


