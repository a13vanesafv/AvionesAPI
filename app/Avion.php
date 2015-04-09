<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Avion extends Model {

	
	//Definimos el nombre la tabla de mysql que usará este modelo
	protected $table = 'aviones';

	//Clave primaria de la tabla aciones
	//Si no se indica por defecto sería un campo llamado "id"
	//En este caso es el campo serie por lo tanto hay que indicarla

	protected $primaryKey='serie';

	//Atributos de la tabla que se pueden rellenar de forma masiva

	protected $fillable=array('modelo', 'longitud', 'capacidad', 'velocidad', 'alcance');

	//Campos que no queremos que se devuelvan en las consultas

	protected $hidden=['created_at', 'updated_at'];


	//Relacion dde Aviones con Fabricante

	public function Fabricante()
	{
		//1 avion pertenece a 1 fabricante

		return $this->belongsTo('\app\Fabricante');

	}



}
