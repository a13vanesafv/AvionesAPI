
<?php

use Illuminate\Database\Seeder;

use App\Fabricante;

//usamos el Faker que instalamos antes
use Faker\Factory as Faker; //como alias


class FabricanteSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//creamos una instancia de faker
		$faker=Faker::create();

		//Vamos a cubrir 5 fabricantes


		for($i=0; $i<5; $i++)
		{
				//Cuando llamamos al metodo create del modelo fabricante
				// se esta creando nueva fila en la tabla de fabricantes

			Fabricante::create(
				[
				'nombre'=>$faker->word(),
				'direccion'=>$faker->word(),
				'telefono'=>$faker->randomNumber()
				]);
		}

	}

}
