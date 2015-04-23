<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//Carganmos fabricante pq los usamos más abajo

use App\Fabricante;
use Response;

//activamo el uso de la s funciones de cache
use Illuminate\Support\Facades\cache;

class FabricanteController extends Controller {

	public function __construct()
	{
		$this->middleware('auth.basic',['only'=>['store', 'update', 'destroy']]);
	}

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
		//cache se ACTUALIZARA CON NUEVOS DATOS CADA 15 SEGUNDOS

		$fabricantes=Cache::remember('cachefabricantes', 15/60, function()
		{
			return Fabricante::all();
		});

		//PARA DEVOLVER UN JSON CON CONDIGO DE RESPUESTA HTTP
		//return response()->json(['status'=>'ok', 'data'=>Fabricante::all()], 200);

		//Devolvemos el Json usando cache
		return response()->json(['status'=>'ok', 'data'=>$fabricantes], 200);

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

		if(!$request->input('nombre') || !$request->input('direccion') || !$request->input('telefono'))
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
	//public function edit($id)
	//{
		//
	//}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		// Comprobación si existe fabricante
		$fabricante = Fabricante::find($id);
		if(!$fabricante) 
		{
			// Deolvemos error
			return response()->json(['errors'=>array(['code' => 404, 'message'=>'No se encuentra un fabricante con ese código'])], 404);
		}
		$nombre = $request->input('nombre');
		$direccion = $request->input('direccion');
		$telefono = $request->input('telefono');
		// Comprobación si recibimos petición path (parcial) o put (total)
		if($request->method() == 'PATCH')
		{
			$bandera = false;
			
			// Actualización parcial de datos
			if($nombre) 
			{
				$fabricante->nombre = $nombre;
				$bandera = true;
			}
			
			if($direccion) 
			{
				$fabricante->direccion = $direccion;
				$direccion = true;
			}
			
			if($telefono) 
			{
				$fabricante->telefono = $telefono;
				$bandera = true;
			}
			if($bandera) 
			{
				$fabricante->save();
				return response()->json(['status'=>'ok' , 'data'=>$fabricante], 200);				
			}
			else
			{
				return response()->json(['errors'=>array(['code' => 304, 'message'=>'No se ha modificado ningún dato del fabricante'])], 304);
			}
		}
		// Método put, actualizamos todos los campos
		if(!$nombre || !$direccion || !$telefono) 
		{
			// 422 Unprocessable Entity
			return response()->json(['errors'=>array(['code' => 422, 'message'=>'Faltan valores para completar el procesamiento'])], 422);
		} 
		// Actualzación de los 3 campos
		$fabricante->nombre = $nombre;
		$fabricante->direccion = $direccion;
		$fabricante->telefono = $telefono;
		$fabricante->save();
		return response()->json(['status'=>'ok' , 'data'=>$fabricante], 200);				
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//Borrado de un fabricante
		//Ejemplo: Fabricante /89 por DELETE
		//Comprobamos si el fabricante existe o no

		$fabricante=Fabricante::find($id);

		//Si no encontramos el fabricante

		if(! $fabricante)
		{
			//Devolcemos error codigo http 404
			return response()->json(['errors'=>array(['code'=>404, 'message'=>'no se encuentra el fabricante'])],404);
		}

		//Borramos el fabricante
		//204 significa n "No content"
		//Este codigo no muestra texto en el body
		//Si quisieramos ver el mensaje devolveriamos
		//un codigo 200
		//antes de borrarlo comprobamos si tiene aviones y si es así
		//SACAMOS UN MENSAJE DE ERROR

		//$aviones=$fabricante->aviones()->get();

		$aviones=$fabricante->aviones;

		if(sizeof($aviones) >0)
		{

			//Si quisiéramos borrar todos los aviones del fabricante sería:
			//$fabricante->aviones->delete();


			//Devolvemos un código 409 Conflict
			return response()->json(['errors'=>array(['code' => 409, 'message'=>'Este fabricante posee aviones y no puede ser eliminado'])], 409);
		}

		//Eliminamos el fabricante si no tiene aviones
		$fabricante->delete();


		return response()->json(['errors'=>array(['code'=>204, 'message'=>'se ha eliminado correctamente'])],204);

	}

}
