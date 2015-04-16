<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Avion;

class AvionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Devuelve la lista de todos los aviones
		return response()->json(['status'=>'ok', 'data'=>Avion::all()], 200);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */


	public function show($id)
	{
		//Buscamos ese avion y si lo encuentra muestra la info
		$avion=Avion::find($id);

		if(! $avion)
			{
				return response()->json(['errors'=>['code'=>404, 'message'=>'no se encuentra avion con ese codigo']], 404);
			}
			return response()->json(['status'=>'ok', 'data'=>$avion], 200);

	}

	

}
