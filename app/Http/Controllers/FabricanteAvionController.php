<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fabricante;
use App\Avion;
use Response;


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

		return response()->json(['status'=>'ok', 'data'=>$fabricante->aviones()->get()], 200); //metodo aviones de Fabricante

		//return response()->json('status'=>'ok', 'data'=>$fabricante->aviones], 200); //metodo 

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($idfabricante, Request $request)
	{
		//DAMOS DE ALTA 1 AVION DE 1 FABRICANTE
		//COMPROBAMOS QUE EXISTE FABRICANTE Y Q ETENEMOS TODOS LOS DATOS DE AVION
		$fabricante=Fabricante::find($idfabricante);

		if (! $fabricante)
		{
			return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])], 404);
		}

		if(!$request->input('modelo') || !$request->input('longitud') || !$request->input('capacidad') || !$request->input('velocidad') ||  !$request->input('alcance'));
		{
			//No estamos recibiendo los datos necesarios. Devuelvo error
			return response()->json(['errors'=>array(['code'=>422, 'message'=>'faltan datos necesarios para el alta'])],422);

		}


		//damos de alta el avion de ese fabricante
		$nuevoAvion=$fabricante->aviones()->create($request)->all();	

		//devolvemos un Json con los datos , código 201 y Location del nuevo recurso creado
$respuesta=Response::make(json_encode(['data'=>$nuevoAvion]), 201)->header('Location', 'http://www.dominio.local/aviones/'.$nuevoAvion->serie)->header('Content-Type', 'application/json');

}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
