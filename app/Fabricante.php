<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model {

	//Definir la tabla mysql que usará ese modelo

	protected $table="fabricantes"; 

	//atributos de la tabla que se oueen rellenar de forma masiva

	protected $fillable=array('nombre', 'direccion', 'telefono');

	//Ocultamos los campos dde timestamps en las consultas

	protected $hidden=['created_at', 'updated_at'];


	//Relacion de Fabricante con avines

	public function aviones()
	{
		//la relacion sería: 1 fabricante hace muchos aviones.
		return $this->hasMany('App\Avion'); //dentro del namespace: avion  
	}



}
