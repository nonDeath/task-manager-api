<?php

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

$app->get('users', 'UsersController@index');
$app->get('users/{user}', 'UsersController@show');
$app->post('users', 'UsersController@store');
$app->patch('users/{user}', 'UsersController@update');
$app->delete('users/{user}', 'UsersController@destroy');

$app->get('priorities', 'PrioritiesController@index');
$app->get('priorities/{priority}', 'PrioritiesController@show');
$app->post('priorities', 'PrioritiesController@store');
$app->patch('priorities/{priority}', 'PrioritiesController@update');
$app->delete('priorities/{priority}', 'PrioritiesController@destroy');

$app->get('tasks', 'TasksController@index');
$app->get('tasks/{task}', 'TasksController@show');
$app->post('tasks', 'TasksController@store');
$app->patch('tasks/{task}', 'TasksController@update');
$app->delete('tasks/{task}', 'TasksController@destroy');
