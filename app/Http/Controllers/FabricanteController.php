<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//Carganmos fabricante pq los usamos más abajo

use App\Fabricante;
use Response;

class FabricanteController extends Controller {

	/**
	 * PROGRAMAMOS LA RUTA POR DEFECTO /FABRICANTES.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return "En el index de Fabricante";
		//DEVOLVEMOS UN JSON CON TODOS LOS FABRICANTES. Usamos el modelo fabricante
		//con el use de arriba ya podemos utilizar el modelo fabricante

		//return Fabricante::all();

		//PARA DEVOLVER UN JSON CON CONDIGO DE RESPUESTA HTTP
		return response()->json(['status'=>'ok', 'data'=>Fabricante::all()], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	//NO SE UTILIZA ESTA METTODO PQ SE USARIA PAR MOSTRAR UN FORMILARIO
	//DE CREACION DE FABRICANTES Y UNA APIREST NO HACE ESO
	/*
	public function create()
	{
		//
	}
*/
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//Metodo llamada el hacer un POST
		//Comprobamos que recibimos todos los campos

		if(!$request->input('nombre') || !$request->input('direccion') || !$request->inpùt('telefono'))
		{
			//No estamos recibiendo los datos necesarios. Devuelvo error
			return response()->json(['errors'=>array(['code'=>422, 'message'=>'faltan datos necesarios para el alta'])],422);

		}
		//Insertamos los datos recibidos en la tabla

		$nuevofabricante=Fabricante::create($request->all());

		//Devovlemos la respuesta Http 201 (Created) +  los datos del nuevo fabricantes + una cabecera de Loacation

		$respuesta=Response::make(json_encode(['data'=>$nuevofabricante]), 201)->header('Location', 'http://www.dominio.local/fabricantes/'.$nuevofabricante->id)->header('Content-Type', 'application/json');
		return $respuesta;

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	//Corresponde a la ruta /fabricantes/{fabricante}
	$fabricante=Fabricante::find($id);

	//Chequeamos si encontro o no el fabricante

	if(! $fabricante)
	{
		//Se devuelve un array errors con los errrores detectados y codigo 404
		return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])], 404);
	}
		//Devolvemos la informacion encontrada
		return response()->json(['status'=>'ok', 'data'=>$fabricante], 200);
	}

	/**
	 * Show the form for editing the specified resource. FORMULARIO PARA EDITAR REGISTROS
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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

	}

}
