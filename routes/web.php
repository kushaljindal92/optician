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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/customer','CustomerController@index');
$router->get('/customer/{id}','CustomerController@show');
$router->delete('/customer/{id}','CustomerController@delete');
$router->post('/customer','CustomerController@create');
$router->put('/customer/{id}','CustomerController@update');
$router->get('/customer/search','CustomerController@search');

