<?php

use Illuminate\Database\Seeder;

//hace uso del modelo de avion
use App\Avion;
use App\Fabricante;

//usamos el Faker que instalamos antes
use Faker\Factory as Faker; //como alias



class AvionSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//creamos una instancia de faker
		$faker=Faker::create();

		//NECESITAMOS SABER CUANTOS FABRICANTES TENEMOS
		//HACEMOS USO MODELO FABRICANTES PARA ELLO, vanesa

		$cuantos=Fabricante::all()->count(); //da JSON CON TODOS LOS FABRICANTES

		//creamos un bucle para cubrir 20 aviones
		for($i=0; $i<19; $i++)
		{
			Avion::create(
				[
				'modelo'=>$faker->word() ,
				'longitud'=>$faker->randomfloat(),
				'capacidad'=>$faker->randomNumber(),
				'velocidad'=>$faker->randomNumber(),
				'alcance'=>$faker->randomNumber(),
				'fabricante_id'=>$faker->numberBetween(1, $cuantos)
				]);
		}
	}
}
