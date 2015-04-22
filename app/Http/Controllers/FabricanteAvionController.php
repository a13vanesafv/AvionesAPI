<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fabricante;
use App\Avion;
use Response;
use Illuminate\Support\Facades\cache;


class FabricanteAvionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idfabricante)
	{

		//Mostramos todos los aviones de un fabricante.
		//Comprobamos si el fabricante exitte

		$fabricante=Fabricante::find($idfabricante);

		if (! $fabricante)
		{
			return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])], 404);
		}


		$listaAviones=Cache::remember('cacheaviones', 1, , function()
		{
			return $fabricante->aviones->get();

		});


		return response()->json(['status'=>'ok', 'data'=>$listaAviones], 200); //metodo aviones de Fabricante

		//return response()->json('status'=>'ok', 'data'=>$fabricante->aviones], 200); //metodo 


	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($idFabricante,Request $request)
	{
		// Damos de alta un avión de un fabricante.
		// Comprobamos que recibimos todos los datos de avión.
		if (! $request->input('modelo') || ! $request->input('longitud') ||! $request->input('capacidad') ||! $request->input('velocidad') ||! $request->input('alcance') )
		{
			// Error 422 Unprocessable Entity.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el alta de avión.'])],422);
		}
		// Compruebo si existe el fabricante.
		$fabricante=Fabricante::find($idFabricante);
		if (! $fabricante)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}
		// Damos de alta el avión de ese fabricante.
		$nuevoAvion=$fabricante->aviones()->create($request->all());
		// Devolvemos un JSON con los datos, código 201 Created y Location del nuevo recurso creado.
		$respuesta= Response::make(json_encode(['data'=>$nuevoAvion]),201)->header('Location','http://www.dominio.local/aviones/'.$nuevoAvion->serie)->header('Content-Type','application/json');
		return $respuesta;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idFabricante, $idAvion, Request $request)
	{
		//Comprobamos si el fabricante 
		$fabricante=Fabricante::find($idFabricante);
		if(! $fabricante)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}
		//Comprobamos si avion q buscamos pertenece a ese fabricante
		$avion = $fabricante->aviones()->find($idAvion);

		if(! $avion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un avion con ese código que pertenezca al fabricante.'])],404);
		}

		//Listado de campos recibidos del formulario de actualizacion
		$modelo=$request->input('modelo');
		$longitud=$request->input('longitud');
		$capacidad=$request->input('capacidad');
		$velocidad=$request->input('velocidad');
		$alcance=$request->input('alcance');


		//Comprobamos si el método es patch o put
		if($request->method()==='PATCH') //actualizacion PARCIAL
		{
			$bandera=false;
			//Comprobamos campo a campo, si hemos recibido datos
			if($modelo)
			{
				//actualizamos este campo en la tabla
				$avion->modelo=$modelo;
				$bandera=true;
			}
			if($longitud)
			{
				//actualizamos este campo en la tabla
				$avion->longitud=$longitud;
				$bandera=true;
			}
			if($capacidad)
			{
				//actualizamos este campo en la tabla
				$avion->capacidad=$capacidad;
				$bandera=true;
			}
			if($velocidad)
			{
				//actualizamos este campo en la tabla
				$avion->velocidad=$velocidad;
				$bandera=true;
			}
			if($alcance)
			{
				//actualizamos este campo en la tabla
				$avion->alcance=$alcance;
				$bandera=true;
			}
			if ($bandera)
			{
				//almacenamos los cambios del modelo en la tabla
				$avion->save();
				return response()->json(['status'=>ok, 'data'=>$avion], 200);
			}
			else{

				//Codigo 304 Not Modified

				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se encuentra un fabricante con ese código.'])],304);
			}
		}

		//METODO PUT- ACTUALIZACION TOTAL
		//Chqueamos que recibimos todos los campos

		if(! $modelo || ! $longitud || !$capacidad || !$velocidad || !$alcance)
		{
			//Codigo 422 UNprocessable Entity
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);

		}

		//Actualizamos el modelo Avion
		$avion->modelo=$modelo;
		$avion->longitud=$longitud;
		$avion->capacidad=$capacidad;
		$avion->velocidad=$velocidad;
		$avion->alcance=$alcance;

		//Grabamos los datos del modelo en la tabla
		$avion->save();

		return response()->json(['status'=>'ok', 'data'=>$avion],200);



	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idFabricante,$idAvion)
	{
		// Compruebo si existe el fabricante.
		$fabricante=Fabricante::find($idFabricante);
		if (! $fabricante)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}
		// Compruebo si existe el avion.
		$avion=$fabricante->aviones()->find($idAvion);
		if (! $avion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un avión asociado a ese fabricante.'])],404);
		}
		// Borramos el avión.
		$avion->delete();
		// Devolvemos código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el avión correctamente.'],204);
	}

}
