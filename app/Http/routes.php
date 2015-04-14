<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');

//Route::get('home', 'HomeController@index');

/*

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

*/

	//CREAMOS LAS RUTAS NUEVAS QUE TENDRAN EN CUENTA LOS CONTROLLERS PROGRAMADOS EN CONTROLLERS



	Route::resource('fabricantes', 'FabricanteController', ['except'=>['create']]);

	Route::resource('aviones', 'AvionController');

	//Ruta por Defecto

	Route::get('/', function()
	{
		return "Bienvenido a API RESTfull de Aviones";
	});