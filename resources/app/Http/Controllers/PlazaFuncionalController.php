<?php namespace App\Http\Controllers;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Redirect;
use Yajra\Datatables\Datatables;
use File;
use Crypt;
use Carbon\Carbon;
use Response;
use DateTime;
use App\PlazasFuncionales;
use App\Models\rrhh\rh\Funciones;
use App\Models\rrhh\rh\Tareas;
use App\Models\rrhh\rh\TareasDesempenios;
use App\Models\rrhh\rh\TareasProductos;
use App\Models\rrhh\rh\TareasConocimientos;
use App\Models\rrhh\rh\TareasActitudes;
use App\Models\rrhh\rh\ConocimientosNiveles;
use App\Models\rrhh\rh\TiposConocimientos;
use App\Models\rrhh\rh\TiposActitudes;

class PlazaFuncionalController extends Controller {

	public function detallePlazaFunc($idPlaza){

		$idplaza = Crypt::decrypt($idPlaza);

		$data = ['title' 			=> 'Detalle de Plaza Funcional'
			,'subtitle'			=> ''
			,'breadcrumb' 		=> [
		 		['nom'	=>	'Plazas funcionales', 'url' => route('plazaFunc.listar')],
		 		['nom'	=>	'Detalle Plaza Funcional', 'url' => ''],

		]];

		$plazaFuncional = PlazasFuncionales::find($idplaza);
		$data['plazaFuncional'] = $plazaFuncional;

		return view('catalogos.plazasFuncionales.detalle',$data);

	}

	public function detalleFuncion($idFuncion){
		$idfuncion = Crypt::decrypt($idFuncion);
		$funcion = Funciones::find($idfuncion);

		$data = ['title' 			=> 'Tareas'
			,'subtitle'			=> ''
			,'breadcrumb' 		=> [
				['nom'	=>	'Plazas funcionales', 'url' => route('plazaFunc.listar')],
		 		['nom'	=>	'Detalle Plaza Funcional', 'url' => route('plazaFunc.detalle',['idPlaza'=>Crypt::encrypt($funcion->idPlazaFuncional)])],
		 		['nom'	=>	'Tareas', 'url' => ''],

		]];

		$data['funcion'] = $funcion;

		return view('catalogos.plazasFuncionales.detalleFuncion',$data);
	}

	public function detalleTarea($idTarea){
		$idtarea = Crypt::decrypt($idTarea);
		$tarea = Tareas::find($idtarea);

		$data = ['title' 			=> 'Detalle Tarea'
			,'subtitle'			=> ''
			,'breadcrumb' 		=> [
		 	['nom'	=>	'Plazas funcionales', 'url' => ''],
		 	['nom'	=>	'Detalle Plaza Funcional', 'url' => ''],
		 	['nom'	=>	'Tareas', 'url' => route('funcion.tareas',['idFuncion'=>Crypt::encrypt($tarea->idFuncion)])],
		 	['nom'	=>	'Detalle Tarea', 'url' => '']

		]];


		$niveles = ConocimientosNiveles::all();
		//$tiposConocimientos = TiposConocimientos::all();
		//$tiposActitudes = TiposActitudes::all();

		$data['tarea'] = $tarea;
		$data['niveles'] = $niveles;
		/*$data['tiposConocimientos'] = $tiposConocimientos;
		$data['tiposActitudes'] = $tiposActitudes;*/

		return view('catalogos.plazasFuncionales.detalleTarea',$data);
	}

	public function editarConocimiento($idConocimiento){

		$id = Crypt::decrypt($idConocimiento);
		$conocimiento = TareasConocimientos::find($id);
		$tipoConocimiento = $conocimiento->tipoConocimiento()->first();
		$niveles = ConocimientosNiveles::all();

		$data = ['title' 			=> 'Editar Conocimiento'
			,'subtitle'			=> ''
			,'breadcrumb' 		=> [
		 		['nom'	=>	'Detalle Tarea', 'url' => ''],
		 		['nom'	=>	'Editar Conocimiento', 'url' => ''],

		]];

		$data['conocimiento'] = $conocimiento;
		$data['tipoConocimiento'] = $tipoConocimiento;
		$data['niveles'] = $niveles;

		return view('catalogos.plazasFuncionales.editarConocimiento',$data);

	}

	public function editarActitud($idActitud){

		$id = Crypt::decrypt($idActitud);
		$actitud = TareasActitudes::find($id);
		$tipoActitud = $actitud->tipoActitud()->first();

		$data = ['title' 			=> 'Editar Actitud'
			,'subtitle'			=> ''
			,'breadcrumb' 		=> [
		 		['nom'	=>	'Detalle Tarea', 'url' => ''],
		 		['nom'	=>	'Editar Actitud', 'url' => ''],

		]];

		$data['actitud'] = $actitud;
		$data['tipoActitud'] = $tipoActitud;

		return view('catalogos.plazasFuncionales.editarActitud',$data);

	}

	public function storeFuncion(Request $request){

		$v = Validator::make($request->all(),[
          'nombreF'    =>  'required',
          'literal'   =>  'required'
      	]);

      	$v->setAttributeNames([
          	'nombreF'    =>  'Nombre de la Función',
          	'literal'    =>  'Literal'
         ]);

	    //Validaciones de sistema
	    if ($v->fails())
	    {
	      $msg = "<ul class='text-warning'>";
	      foreach ($v->messages()->all() as $err) {
	        $msg .= "<li>$err</li>";
	      }
	      $msg .= "</ul>";
	      return $msg;
	    }

	    DB::beginTransaction();
		try{

			//Verificamos que el literal de la función no exista
			$cantidadRegistros = Funciones::where('literal',strtoupper($request->literal))->where('idPlazaFuncional',$request->idPlazaFuncional)->where('activo',1)->count();

			if($cantidadRegistros < 1){

				$funcion = new Funciones;
				$funcion->idPlazaFuncional = $request->idPlazaFuncional;
				$funcion->nombreFuncion = $request->nombreF;
				$funcion->literal = strtoupper($request->literal);
				$funcion->activo = 1;
				$funcion->idUsuarioCrea = Auth::user()->idUsuario;

				$funcion->save();
			}else{
				return $msg = "<ul class='text-warning'><li>Ya existe una Función con el literal ".strtoupper($request->literal)." para esta Plaza Funcional, revise e intente nuevamente.</li></ul>";
			}


		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}


	public function editarFuncion(Request $request){

		if($request->nombreFuncion==""){
			return $msg = "<ul class='text-warning'><li>Debe Ingresar el nombre de la función</li></ul>";
		}


		DB::beginTransaction();
		try{

			$funcion = Funciones::find($request->idFuncion);
			$funcion->nombreFuncion = $request->nombreFuncion;
			$funcion->literal = strtoupper($request->literal);
			$funcion->idUsuarioModifica = Auth::user()->idUsuario;
			$funcion->activo = $request->estado;

			$funcion->save();

		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}

	public function storeTarea(Request $request){

		if($request->nombreTarea==""){
			return $msg = "<ul class='text-warning'><li>Debe Ingresar el nombre de la tarea</li></ul>";
		}

		DB::beginTransaction();
		try{

			if($request->idTarea!=""){
				$tarea = Tareas::find($request->idTarea);
				$tarea->nombreTarea = $request->nombreTarea;
				$tarea->idUsuarioModifica = Auth::user()->idUsuario;

				$tarea->save();
			}else{


				//obtenemos el máximo número de tarea
        		$ultimaTarea = Tareas::where('idFuncion',$request->idFuncion)->orderBy('numero','DESC')->take(1)->first();
        		if($ultimaTarea!=null){
        			$numero = (int)$ultimaTarea->numero;
        		}else{
        			$numero = 0;
        		}

				$tarea = new Tareas;
				$tarea->idFuncion = $request->idFuncion;
				$tarea->numero = $numero+1;
				$tarea->nombreTarea = $request->nombreTarea;
				$tarea->activo = 1;
				$tarea->idUsuarioCrea = Auth::user()->idUsuario;

				$tarea->save();

			}


		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}

	public function eliminarTarea($idTarea){

	    $idtarea= Crypt::decrypt($idTarea);

	    DB::beginTransaction();
	      try{

	      	$tarea = tareas::find($idtarea);
	      	$tarea->activo = 0;
	      	$tarea->save();

	      }catch(Exception $e){
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        return $e->getMessage();
	      }

	      DB::connection('sqlsrv')->commit();

	      Session::put('msnExito', '¡LA TAREA FUE ELIMINADA CON EXITO!');
	      return redirect()->back();

	}

	public function eliminarDesempenio($idDesempenio){

	    $iddesempenio= Crypt::decrypt($idDesempenio);

	    DB::beginTransaction();
	      try{

	      	$desempenio = TareasDesempenios::find($iddesempenio);
	      	$desempenio->activo = 0;
	      	$desempenio->save();

	      }catch(Exception $e){
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        return $e->getMessage();
	      }

	      DB::connection('sqlsrv')->commit();

	      Session::put('msnExitoD', '¡EL CRITERIO DE DESEMPEÑO FUE ELIMINADO CON EXITO!');
	      return redirect()->back();
	}

	public function eliminarProducto($idProducto){

	    $idproducto= Crypt::decrypt($idProducto);

	    DB::beginTransaction();
	      try{

	      	$producto = TareasProductos::find($idproducto);
	      	$producto->activo = 0;
	      	$producto->save();

	      }catch(Exception $e){
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        return $e->getMessage();
	      }

	      DB::connection('sqlsrv')->commit();

	      Session::put('msnExitoP', '¡EL PRODUCTO FUE ELIMINADO CON EXITO!');
	      return redirect()->back();

	}


	public function eliminarConocimiento($idConocimiento){

	    $idconocimiento= Crypt::decrypt($idConocimiento);

	    DB::beginTransaction();
	      try{

	      	$conocimiento = TareasConocimientos::find($idconocimiento);
	      	$conocimiento->activo = 0;
	      	$conocimiento->save();

	      }catch(Exception $e){
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        return $e->getMessage();
	      }

	      DB::connection('sqlsrv')->commit();

	      Session::put('msnExitoC', '¡EL CONOCIMIENTO FUE ELIMINADO CON EXITO!');
	      return redirect()->back();

	}

	public function eliminarActitud($idActitud){

	    $idactitud= Crypt::decrypt($idActitud);

	    DB::beginTransaction();
	      try{

	      	$actitud = TareasActitudes::find($idactitud);
	      	$actitud->activo = 0;
	      	$actitud->save();

	      }catch(Exception $e){
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        return $e->getMessage();
	      }

	      DB::connection('sqlsrv')->commit();

	      Session::put('msnExitoA', '¡LA ACTITUD FUE ELIMINADA CON EXITO!');
	      return redirect()->back();

	}

	public function eliminarFuncion($idFuncion){

	    $idfuncion= Crypt::decrypt($idFuncion);

	    DB::beginTransaction();
	      try{

	      	$funcion = Funciones::find($idfuncion);
	      	$funcion->activo = 0;
	      	$funcion->save();

	      }catch(Exception $e){
	        DB::connection('sqlsrv')->rollback();
	        throw $e;
	        return $e->getMessage();
	      }

	      DB::connection('sqlsrv')->commit();

	      Session::put('msnExito', '¡LA FUNCIÓN FUE ELIMINADA CON EXITO!');
	      return redirect()->back();

	}

	public function findTipoConocimientoSelectize(Request $request){
		$query = e($request->q);

		if(!$query && $query == '') return response()->json(array(), 400);

		$data = TiposConocimientos::findTipoConocimientoSelectize($query);

		return response()->json(array(
			'data'=>$data
		));
	}

	public function findTipoActitudSelectize(Request $request){
		$query = e($request->q);

		if(!$query && $query == '') return response()->json(array(), 400);

		$data = TiposActitudes::findTipoActitudSelectize($query);

		return response()->json(array(
			'data'=>$data
		));
	}

	public function storeCriterio(Request $request){

		if($request->nombreCriterio==""){
			return $msg = "<ul class='text-warning'><li>Debe Ingresar el nombre del Criterio de Desempeño</li></ul>";
		}

		DB::beginTransaction();
		try{

			if($request->idCriterio!=""){//Editando Criterio de desempeño

				$criterio = TareasDesempenios::find($request->idCriterio);
				$criterio->nombreDesempenio = $request->nombreCriterio;
				$criterio->idUsuarioModifica = Auth::user()->idUsuario;
				$criterio->fechaModificacion = Carbon::now();

				$criterio->save();

			}else{//Creando un nuevo Criterio de desempeño

				//obtenemos el máximo número de criterio
        		$ultimoCriterio = TareasDesempenios::where('idTarea',$request->idTareaCriterio)->orderBy('numero','DESC')->where('activo',1)->take(1)->first();

        		if($ultimoCriterio!=null){
        			$numero = (int)$ultimoCriterio->numero;
        		}else{
        			$numero = 0;
        		}

				$criterio = new TareasDesempenios;
				$criterio->idTarea = $request->idTareaCriterio;
				$criterio->numero = $numero+1;
				$criterio->nombreDesempenio = $request->nombreCriterio;
				$criterio->activo = 1;
				$criterio->idUsuarioCrea = Auth::user()->idUsuario;

				$criterio->save();

			}


		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}

	public function storeProducto(Request $request){

		if($request->nombreProducto==""){
			return $msg = "<ul class='text-warning'><li>Debe Ingresar el nombre del Producto</li></ul>";
		}

		DB::beginTransaction();
		try{

			if($request->idProducto!=""){//Editando Producto

				$producto = TareasProductos::find($request->idProducto);
				$producto->nombreProducto= $request->nombreProducto;
				$producto->idUsuarioModifica = Auth::user()->idUsuario;
				$producto->fechaModificacion = Carbon::now();

				$producto->save();

			}else{//Creando un nuevo Producto

				//obtenemos el máximo número de producto
        		$ultimoProducto = TareasProductos::where('idTarea',$request->idTareaProducto)->orderBy('numero','DESC')->where('activo',1)->take(1)->first();

        		if($ultimoProducto!=null){
        			$numero = (int)$ultimoProducto->numero;
        		}else{
        			$numero = 0;
        		}

				$producto = new TareasProductos;
				$producto->idTarea = $request->idTareaProducto;
				$producto->numero = $numero+1;
				$producto->nombreProducto = $request->nombreProducto;
				$producto->activo = 1;
				$producto->idUsuarioCrea = Auth::user()->idUsuario;

				$producto->save();

			}


		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}

	public function storeConocimiento(Request $request){

		$v = Validator::make($request->all(),[
          'tipoConocimiento'    =>  'required',
          'nombreConocimiento'   =>  'required',
          'nivel'	=>	'required'
      	]);

      	$v->setAttributeNames([
          	'tipoConocimiento'    =>  'Tipo de Conocimiento',
          	'nombreConocimiento'    =>  'Nombre del Conocimiento',
          	'nivel'	=>	'Nivel'
         ]);

	    //Validaciones de sistema
	    if ($v->fails())
	    {
	      $msg = "<ul class='text-warning'>";
	      foreach ($v->messages()->all() as $err) {
	        $msg .= "<li>$err</li>";
	      }
	      $msg .= "</ul>";
	      return $msg;
	    }

	    DB::beginTransaction();
		try{

			if($request->idConocimiento!=""){//Editando Conocimiento

				$conocimiento = TareasConocimientos::find($request->idConocimiento);
				$conocimiento->nombreConocimiento= $request->nombreConocimiento;
				$conocimiento->idNivel = $request->nivel;
				$conocimiento->idTipoConocimiento = $request->tipoConocimiento;
				$conocimiento->idUsuarioModifica = Auth::user()->idUsuario;
				$conocimiento->fechaModificacion = Carbon::now();

				$conocimiento->save();

			}else{//Creando un nuevo Conocimiento

				//verificamos que no exista el conocimiento para esa tarea
				$cantidadRegistros = TareasConocimientos::where('idTarea',$request->idTareaConocimiento)->where('idTipoConocimiento',$request->tipoConocimiento)->where('activo',1)->count();

				if($cantidadRegistros < 1){
					//obtenemos el máximo número de conocimiento
	        		$ultimoConocimiento = TareasConocimientos::where('idTarea',$request->idTareaConocimiento)->orderBy('numero','DESC')->where('activo',1)->take(1)->first();

	        		if($ultimoConocimiento!=null){
	        			$numero = (int)$ultimoConocimiento->numero;
	        		}else{
	        			$numero = 0;
	        		}

					$conocimiento = new TareasConocimientos;
					$conocimiento->idTarea = $request->idTareaConocimiento;
					$conocimiento->numero = $numero+1;
					$conocimiento->nombreConocimiento = $request->nombreConocimiento;
					$conocimiento->idNivel = $request->nivel;
					$conocimiento->idTipoConocimiento = $request->tipoConocimiento;
					$conocimiento->activo = 1;
					$conocimiento->idUsuarioCrea = Auth::user()->idUsuario;

					$conocimiento->save();
				}else{
					return $msg = "<ul class='text-warning'><li>Ya Existe el Conocimiento ingresado para esta tarea, revise e intente nuevamente.</li></ul>";
				}

			}


		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}

	public function storeActitud(Request $request){

		$v = Validator::make($request->all(),[
          'tipoActitud'    =>  'required',
          'nombreActitud'   =>  'required'
      	]);

      	$v->setAttributeNames([
          	'tipoActitud'    =>  'Tipo de Actitud',
          	'nombreActitud'    =>  'Nombre de Actitud'
         ]);

	    //Validaciones de sistema
	    if ($v->fails())
	    {
	      $msg = "<ul class='text-warning'>";
	      foreach ($v->messages()->all() as $err) {
	        $msg .= "<li>$err</li>";
	      }
	      $msg .= "</ul>";
	      return $msg;
	    }

	    DB::beginTransaction();
		try{

			if($request->idActitud!=""){//Editando Actitud

				$actitud = TareasActitudes::find($request->idActitud);
				$actitud->nombreActitud= $request->nombreActitud;
				$actitud->idTipoActitud = $request->tipoActitud;
				$actitud->idUsuarioModifica = Auth::user()->idUsuario;
				$actitud->fechaModificacion = Carbon::now();

				$actitud->save();

			}else{//Creando una nueva Actitud

				//verificamos que no exista la actitud para esa tarea
				$cantidadRegistros = TareasActitudes::where('idTarea',$request->idTareaActitud)->where('idTipoActitud',$request->tipoActitud)->where('activo',1)->count();

				if($cantidadRegistros < 1){
					//obtenemos el máximo número de actitud
	        		$ultimaActitud = TareasActitudes::where('idTarea',$request->idTareaActitud)->orderBy('numero','DESC')->where('activo',1)->take(1)->first();

	        		if($ultimaActitud!=null){
	        			$numero = (int)$ultimaActitud->numero;
	        		}else{
	        			$numero = 0;
	        		}

					$actitud = new TareasActitudes;
					$actitud->idTarea = $request->idTareaActitud;
					$actitud->numero = $numero+1;
					$actitud->nombreActitud = $request->nombreActitud;
					$actitud->idTipoActitud = $request->tipoActitud;
					$actitud->activo = 1;
					$actitud->idUsuarioCrea = Auth::user()->idUsuario;

					$actitud->save();
				}else{
					return $msg = "<ul class='text-warning'><li>Ya Existe la Actitud ingresada para esta tarea, revise e intente nuevamente.</li></ul>";
				}

			}


		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);

	}

	public function storeTipoConocimiento(Request $request){

		if($request->nombreTipoConocimiento==""){
			return $msg = "<ul class='text-warning'><li>Debe Ingresar el nombre del Tipo de Conocimiento.</li></ul>";
		}

		DB::beginTransaction();
		try{
			//verificamos que no exista un tipo de conocimiento con ese nombre

				$tipoConocimiento = new TiposConocimientos;
				$tipoConocimiento->nombreTipoConocimiento = strtoupper($request->nombreTipoConocimiento);
				$tipoConocimiento->activo = 1;
				$tipoConocimiento->idUsuarioCrea = Auth::user()->idUsuario;

				$tipoConocimiento->save();

		}catch(Exception $e){
			DB::rollback();
        	throw $e;
        	return $e->getMessage();
		}

		DB::commit();

		return response()->json(['state' => 'success']);


	}
}