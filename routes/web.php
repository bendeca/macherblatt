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

$router->get('/', function () use ($router) {
    return view('app');
});

$router->post('/visits/checkin', 'VisitController@checkin');
$router->post('/visits/checkout', 'VisitController@checkout');

$router->get('/visits', 'VisitController@index');
$router->get('/visits/{id}', 'VisitController@show');

$router->put('/visits/{visit}', 'VisitController@update');
$router->delete('/visits/{visit}', 'VisitController@destroy');
