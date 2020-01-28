<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Unidades;
use App\PlazasFuncionales;
use App\Models\rrhh\edc\resultados\CompetenciasEstados;
use App\Http\Controllers\Controller;
use App\Models\rrhh\edc\Evaluaciones;
use App\Models\rrhh\edc\ConocimientosTipos;
use App\Models\rrhh\edc\CapacitacionesModel;
use App\Models\rrhh\edc\CapacitacionesDetalle;
use App\Models\rrhh\edc\vwProductos;
use App\Models\rrhh\edc\resultados\vwConocimientos;
use App\Models\rrhh\rh\ActitudesTipos;
use App\Models\rrhh\edc\vwActitudes;
use Illuminate\Http\Request;
use App\Http\Requests\capacitacionRequest;	
use App\Models\rrhh\edc\vwDesempenios;
use App\Models\rrhh\edc\resultados\Resultados;
use App\Models\rrhh\rh\Empleados;
use App\Models\rrhh\edc\resultados\Tareas as ResultadosTar;
use Datatables;
use DB;
use Auth;
use Debugbar;
use Log;
use Excel;
use Validator;
use Crypt;
use Session;

class ResultadoEvaluacionesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');

	}

	//------------------------------DESEMPEÑOS-------------------------------------

	public function indexDesemp(){
		try{
			$data = ['title' 			=> 'Plan de Capacitaciones'
					,'subtitle'			=> 'Análisis resultados EDC'
					,'breadcrumb' 		=> [
						['nom'	=>	'Plan de Capacitaciones', 'url' => '#'],
			 			['nom'	=>	'Análisis resultados EDC', 'url' => route('rh.capacitaciones.plan')],
			 			['nom'	=>	'Desempeños', 'url' => '#'],
					]];
			$data['unidades']= Unidades::orderBy('nombreUnidad','asc')->get();
			$data['funcionales']= PlazasFuncionales::orderBy('nombrePlaza','asc')->get();
			$data['estados']= CompetenciasEstados::orderBy('nombreEstado','asc')->get();
			$data['evaluaciones'] = Evaluaciones::orderBy('fechaCreacion','desc')->get();

			$data['capacitaciones'] = CapacitacionesModel::getCmbData();
			$data['tipo'] = 1; //Desempeños

			return view ('capacitaciones.analisis.desempenio',$data); 

		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}
	}
	public function getDataRowsDesemp(Request $request){
		if($request->searchCount > 0){
			$desempenios=vwDesempenios::where('idEstado',$request->estado);

			return Datatables::of($desempenios)
				->addColumn('add', function ($dt) {
        			return '<input type="checkbox" name="idResDet[\''.$dt->idResultado.'~'.$dt->idDesempenio.'\']" value="'.$dt->idResultado.'~'.$dt->idDesempenio.'">';
	            })
	            ->filter(function($query) use ($request){
					if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
					if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
					if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
					

	        	})->removeColumn('idPlazaFuncional')->removeColumn('idEstado')->removeColumn('idEvaluacion')
	    		->make(true);
		}else{
	 		$results = ["draw" 			  => 0,		            
		        		"recordsTotal"    => 0,
		        		"recordsFiltered" => 0,
		          		"data"            => []];
			return json_encode($results);
	 	}
	}

	public function exportToExcelDesemp(Request $request){
		if($request->searchCount > 0){
			$desempeniosCat =vwDesempenios::where('idEstado',$request->estado)->where(function($query) use($request){
				if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
				if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
				if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
			})->select('idDesempenio')->distinct();
					
			$file = Excel::create('EDC_Desempenios', function($excel) use ($desempeniosCat,$request) {
				 $excel->sheet('Desempeños', function($sheet) use ($desempeniosCat,$request) {
				 	//$rowNumber = 1;
				 	$sheet->appendRow([
						    'nombreDesempenio','idEmpleado', 'nombreEmpleado','nombrePlaza','nombreUnidad','nombreFuncion','nombreTarea','nombreEstado','accionTomar','nombreEvaluacion']);
				 	foreach ($desempeniosCat->get() as $dc) {
				 		//$rowIni = $rowNumber + 1;
				 		
						$cuerpo = vwDesempenios::where('idEstado',$request->estado)->where(function($query) use($request){
							if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
							if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
							if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
						})->where('idDesempenio',$dc->idDesempenio)->orderBy('idUnidad','asc')->orderBy('idEmpleado','asc');
						
						foreach ($cuerpo->get() as $ddet) {
							//$rowNumber++;
							$sheet->appendRow([
							    $ddet->nombreDesempenio,$ddet->idEmpleado, $ddet->nombreEmpleado,$ddet->nombrePlaza,$ddet->nombreUnidad,$ddet->nombreFuncion,$ddet->nombreTarea,$ddet->nombreEstado,$ddet->accionTomar,$ddet->nombreEvaluacion
							]);
							
						}
						//$sheet->mergeCells('A'.$rowIni.':A'.$rowNumber);
				 	}
				 	$sheet->setAutoFilter();
			    });
			})->string('xlsx');

			return response()->json([
					'name' => "EDC_Desempenios", //no extention needed
   					'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($file) //mime type of used format
				]);
		}
	}

	//-----------------------------PRODUCTOS----------------------------------
	public function indexProductos(){
		
		try{
			$data = ['title' 			=> 'Plan de Capacitaciones'
					,'subtitle'			=> 'Análisis resultados EDC'
					,'breadcrumb' 		=> [
						['nom'	=>	'Plan de Capacitaciones', 'url' => '#'],
			 			['nom'	=>	'Análisis resultados EDC', 'url' => route('rh.capacitaciones.plan')],
			 			['nom'	=>	'Productos', 'url' => '#'],
					]];
			$data['unidades']= Unidades::orderBy('nombreUnidad','asc')->get();
			$data['funcionales']= PlazasFuncionales::orderBy('nombrePlaza','asc')->get();
			$data['estados']= CompetenciasEstados::orderBy('nombreEstado','asc')->get();
			$data['evaluaciones'] = Evaluaciones::orderBy('fechaCreacion','desc')->get();

			$data['capacitaciones'] = 	CapacitacionesModel::getCmbData();
			$data['tipo'] = 2; //Productos
			
			return view('capacitaciones.analisis.productos',$data);
		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}
	}
	public function getDataRowsProductos(Request $request){
		if($request->searchCount > 0){
			$prod = vwProductos::where('idEstado',$request->estado);
		
        return Datatables::of($prod)
        	->addColumn('add', function ($dt) {
    			return '<input type="checkbox" name="idResDet[\''.$dt->idResultado.'~'.$dt->idProducto.'\']" value="'.$dt->idResultado.'~'.$dt->idProducto.'">';
            })->filter(function($query) use ($request){
				if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
				if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
				if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
				

        	})->removeColumn('idPlazaFuncional')->removeColumn('idEstado')->removeColumn('idEvaluacion')
    		->make(true);
    	}else{
	 		$results = ["draw" 			  => 0,		            
		        		"recordsTotal"    => 0,
		        		"recordsFiltered" => 0,
		          		"data"            => []];
			return json_encode($results);
	 	}
	}

	public function exportToExcelProductos(Request $request){
		if($request->searchCount > 0){
			$productosCat =vwProductos::where('idEstado',$request->estado)->where(function($query) use($request){
				if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
				if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
				if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
			})->select('idProducto')->distinct();
					
			$file = Excel::create('EDC_Productos', function($excel) use ($productosCat,$request) {
				 $excel->sheet('Productos', function($sheet) use ($productosCat,$request) {
				 	//$rowNumber = 1;
				 	$sheet->appendRow([
						    'nombreProducto','idEmpleado', 'nombreEmpleado','nombrePlaza','nombreUnidad','nombreFuncion','nombreTarea','nombreEstado','accionTomar','nombreEvaluacion']);
				 	foreach ($productosCat->get() as $dc) {
				 		//$rowIni = $rowNumber + 1;
				 		
						$cuerpo = vwProductos::where('idEstado',$request->estado)->where(function($query) use($request){
							if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
							if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
							if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
						})->where('idProducto',$dc->idProducto)->orderBy('idUnidad','asc')->orderBy('idEmpleado','asc');
						
						foreach ($cuerpo->get() as $ddet) {
							//$rowNumber++;
							$sheet->appendRow([
							    $ddet->nombreProducto,$ddet->idEmpleado, $ddet->nombreEmpleado,$ddet->nombrePlaza,$ddet->nombreUnidad,$ddet->nombreFuncion,$ddet->nombreTarea,$ddet->nombreEstado,$ddet->accionTomar,$ddet->nombreEvaluacion
							]);
							
						}
						//$sheet->mergeCells('A'.$rowIni.':A'.$rowNumber);
				 	}
				 	$sheet->setAutoFilter();
			    });
			})->string('xlsx');

			return response()->json([
					'name' => "EDC_Producto", //no extention needed
   					'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($file) //mime type of used format
				]);
		}
	}
	//-----------------------------CONOCIMIENTOS----------------------------------
	public function indexConocimientos(){
		try{
			$data = ['title' 			=> 'Plan de Capacitaciones'
					,'subtitle'			=> 'Análisis resultados EDC'
					,'breadcrumb' 		=> [
						['nom'	=>	'Plan de Capacitaciones', 'url' => '#'],
			 			['nom'	=>	'Análisis resultados EDC', 'url' => route('rh.capacitaciones.plan')],
			 			['nom'	=>	'Conocimientos', 'url' => '#'],
					]];
			$data['unidades']= Unidades::orderBy('nombreUnidad','asc')->get();
			$data['funcionales']= PlazasFuncionales::orderBy('nombrePlaza','asc')->get();
			$data['estados']= CompetenciasEstados::orderBy('nombreEstado','asc')->get();
			$data['evaluaciones'] = Evaluaciones::orderBy('fechaCreacion','desc')->get();

			$data['capacitaciones'] = CapacitacionesModel::getCmbData();
			$data['tipo'] = 3; //Conocimientos

			$data['categorias'] = ConocimientosTipos::getCmbData();

			return view ('capacitaciones.analisis.conocimientos',$data); 

		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}
	}
	public function getDataRowsConocimientos(Request $request){
		if($request->searchCount > 0){
			$conocimientos=vwConocimientos::where('idEstado',$request->estado)->select('idResultado','idEmpleado','nombreEmpleado', 'idPlazaFuncional','nombrePlaza','idUnidad','nombreUnidad','idTipoConocimiento','nombreTipoConocimiento','idEvaluacion','nombreEvaluacion','periodoEvaluacion')->distinct();

			return Datatables::of($conocimientos)
				->addColumn('add', function ($dt) {
        			return '<input type="checkbox" name="idResDet[\''.$dt->idResultado.'~'.$dt->idTipoConocimiento.'\']" value="'.$dt->idResultado.'~'.$dt->idTipoConocimiento.'">';
	            })->filter(function($query) use ($request){
					if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
					if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
					if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
					if($request->has('categoria'))		$query->whereIn('idTipoConocimiento',$request->categoria);
	        	})->removeColumn('idPlazaFuncional')->removeColumn('idEstado')->removeColumn('idEvaluacion')
	    		->make(true);
		}else{
	 		$results = ["draw" 			  => 0,		            
		        		"recordsTotal"    => 0,
		        		"recordsFiltered" => 0,
		          		"data"            => []];
			return json_encode($results);
	 	}
	}
		public function exportToExcelConocimientos(Request $request){
		if($request->searchCount > 0){
			$file = Excel::create('EDC_Conocimientos', function($excel) use ($request) {
				 $excel->sheet('Conocimientos', function($sheet) use ($request) {
				 	//$rowNumber = 1;
				 	$sheet->appendRow([
						    'nombreConocimiento','idEmpleado', 'nombreEmpleado','nombrePlaza','nombreUnidad','nombreEstado','nombreEvaluacion']);
				 	
				 	$estado = CompetenciasEstados::find($request->estado);
					$cuerpo = vwConocimientos::where('idEstado',$request->estado)->where(function($query) use($request){
						if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
						if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
						if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
						if($request->has('categoria'))		$query->whereIn('idTipoConocimiento',$request->categoria);
					})->orderBy('idTipoConocimiento','asc')->orderBy('idUnidad','asc')->orderBy('idEmpleado','asc');
					
					foreach ($cuerpo->get() as $ddet) {
						//$rowNumber++;
						$sheet->appendRow([
						    $ddet->nombreTipoConocimiento,$ddet->idEmpleado, $ddet->nombreEmpleado,$ddet->nombrePlaza,$ddet->nombreUnidad,$estado->nombreEstado,$ddet->nombreEvaluacion
						]);
						
					}
					//$sheet->mergeCells('A'.$rowIni.':A'.$rowNumber);
				 	$sheet->setAutoFilter();
			    });
			})->string('xlsx');

			return response()->json([
					'name' => "EDC_Conocimientos", //no extention needed
   					'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($file) //mime type of used format
				]);
		}
	}
	//---------------------------------------ACTITUDES--------------------------------------
		public function indexActitudes(){
		try{
			$data = ['title' 			=> 'Plan de Capacitaciones'
					,'subtitle'			=> 'Análisis resultados EDC'
					,'breadcrumb' 		=> [
						['nom'	=>	'Plan de Capacitaciones', 'url' => '#'],
			 			['nom'	=>	'Análisis resultados EDC', 'url' => route('rh.capacitaciones.plan')],
			 			['nom'	=>	'Actitudes', 'url' => '#'],
					]];
			$data['unidades']= Unidades::orderBy('nombreUnidad','asc')->get();
			$data['funcionales']= PlazasFuncionales::orderBy('nombrePlaza','asc')->get();
			$data['estados']= CompetenciasEstados::orderBy('nombreEstado','asc')->get();
			$data['evaluaciones'] = Evaluaciones::orderBy('fechaCreacion','desc')->get();

			$data['capacitaciones'] = CapacitacionesModel::getCmbData();
			$data['tipo'] = 4; //Actitudes

			$data['categorias'] = ActitudesTipos::getCmbData();

			return view ('capacitaciones.analisis.actitudes',$data); 

		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}
	}

	public function getDataRowsActitudes(Request $request){
		if($request->searchCount > 0){
			$conocimientos=vwActitudes::where('idEstado',$request->estado)->select('idResultado','idEmpleado','nombreEmpleado', 'idPlazaFuncional','nombrePlaza','idUnidad','nombreUnidad','idTipoActitud','nombreTipoActitud','idEvaluacion','nombreEvaluacion','periodoEvaluacion')->distinct();

			return Datatables::of($conocimientos)
				->addColumn('add', function ($dt) {
        			return '<input type="checkbox" name="idResDet[\''.$dt->idResultado.'~'.$dt->idTipoActitud.'\']" value="'.$dt->idResultado.'~'.$dt->idTipoActitud.'">';
	            })->filter(function($query) use ($request){
					if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
					if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
					if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
					if($request->has('categoria'))		$query->whereIn('idTipoActitud',$request->categoria);
					

	        	})->removeColumn('idPlazaFuncional')->removeColumn('idEstado')->removeColumn('idEvaluacion')
	    		->make(true);
		}else{
	 		$results = ["draw" 			  => 0,		            
		        		"recordsTotal"    => 0,
		        		"recordsFiltered" => 0,
		          		"data"            => []];
			return json_encode($results);
	 	}
	}
		public function exportToExcelActitudes(Request $request){
		if($request->searchCount > 0){
			$file = Excel::create('EDC_Actitudes', function($excel) use ($request) {
				 $excel->sheet('Actitudes', function($sheet) use ($request) {
				 	//$rowNumber = 1;
				 	$sheet->appendRow([
						    'nombreActitud','idEmpleado', 'nombreEmpleado','nombrePlaza','nombreUnidad','nombreEstado','nombreEvaluacion']);
				 	
				 	$estado = CompetenciasEstados::find($request->estado);
					$cuerpo = vwActitudes::where('idEstado',$request->estado)->where(function($query) use($request){
						if($request->has('unidad'))			$query->whereIn('idUnidad',$request->unidad);
						if($request->has('plazaFuncional'))	$query->whereIn('idPlazaFuncional',$request->plazaFuncional);
						if($request->evaluacion <> "-1")	$query->where('idEvaluacion',$request->evaluacion);
						if($request->has('categoria'))		$query->whereIn('idTipoActitud',$request->categoria);
					})->orderBy('idTipoActitud','asc')->orderBy('idUnidad','asc')->orderBy('idEmpleado','asc');
					
					foreach ($cuerpo->get() as $ddet) {
						//$rowNumber++;
						$sheet->appendRow([
						    $ddet->nombreTipoActitud,$ddet->idEmpleado, $ddet->nombreEmpleado,$ddet->nombrePlaza,$ddet->nombreUnidad,$estado->nombreEstado,$ddet->nombreEvaluacion
						]);
						
					}
					//$sheet->mergeCells('A'.$rowIni.':A'.$rowNumber);
				 	$sheet->setAutoFilter();
			    });
			})->string('xlsx');

			return response()->json([
					'name' => "EDC_Actitudes", //no extention needed
   					'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($file) //mime type of used format
				]);
		}
	}


	public function mostrarTemporales($idEmpleado){

		try{
			$idEmpleado = Crypt::decrypt($idEmpleado);

			$data = ['title' 			=> 'Resultado de la evaluación' 
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Empleados Temporales Evaluaciones', 'url' => '#'],
				 		['nom'	=>	'Mostrar', 'url' => '']
			]];

			//Datos de Prueba 252 y 1		
			//22 es el ID de Evaluación para Personal En Pruebas
			$resultado = Resultados::where('idEmpleado',$idEmpleado)->where('idEvaluacion',5)->first();

			$data['resultado'] = $resultado;
			if($resultado!=null){
				$data['eva'] = Evaluaciones::findOrFail($resultado->idEvaluacion);
				$data['emp'] = Empleados::findOrFail($resultado->idEmpleado);
				$data['is_historic'] = true;
			}else{

				return view('errors.generic',['error' => 'No hay Resultado de Evaluación para los datos proporcionados!']);
			}
			

			return view('edc.empleado.personal',$data);
		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}

	}

	public function mostrarTarea(Request $request, $idRes, $idTar){
		try{
			$idResultado = Crypt::decrypt($idRes);
			$idTarea = Crypt::decrypt($idTar);

			$resultado = Resultados::findOrFail($idResultado);
			$reTar = ResultadosTar::where('idResultado',$idResultado)->where('idTarea',$idTarea)->first();
			if(empty($reTar)){
				return view('errors.generic',['error' => 'No hay evaluaciones de desempeño para los datos proporcionados!']);
			}
			
			$data = ['title' 			=> 'Mostrar Tarea' 
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Empleados Temporales Evaluaciones', 'url' => '#'],
				 		['nom'	=>	'Mostrar', 'url' => ''],
				 		['nom'	=>	'Tarea', 'url' => '#']
					]]; 
			
			$data['emp'] = Empleados::findOrFail($resultado->idEmpleado);
			$data['resultado'] = $resultado;
			$data['reTar'] = $reTar;
			$data['estados'] = 	CompetenciasEstados::getDataEstados();
			$data['idRes'] = $idRes;
			$data['is_historic'] = true;

			return view('edc.empleado.tareaShow',$data);
		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}catch(DecryptException $de){
			return view('errors.generic',['error' => 'Algo salio mal, parece que los datos proporcionados no son validos!']);
		}
	}

}