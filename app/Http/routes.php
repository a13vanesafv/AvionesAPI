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


	//Ruta /fabricantes/....

	Route::resource('fabricantes', 'FabricanteController', ['except'=>['create']]);


	//recurso anidado /fabricante/XX/aviones
	//PARA PODER GESTIONAR LAS ALTAS DE LOS AVIONES Y TENER LA REFERENCIA DEL FABRICANTES DEL AVION
	Route::resource('fabricantes.aviones','FabricanteAvionController', ['except'=>['edit', 'create', 'show']]);

	//Ruta /aviones/....
	//Aquí gestiono el index y el show, las otras peticiones van en el anterior!!!!!**********
	//el resto de métodos los gestiona FabricantesAvion
	Route::resource('aviones', 'AvionController', ['only'=>['index', 'show']]);

	//Ruta por Defecto

	Route::get('/', function()
	{
		return "Bienvenido a API RESTfull de Aviones";
	});