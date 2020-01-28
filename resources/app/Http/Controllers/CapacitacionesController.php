<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Unidades;
use App\PlazasFuncionales;
use App\Models\rrhh\edc\resultados\CompetenciasEstados;
use App\Http\Controllers\Controller;
use App\Models\rrhh\edc\Evaluaciones;
use App\Models\rrhh\edc\CapacitacionesModel;
use App\Models\rrhh\edc\CapacitacionesDetalle;
use App\Models\rrhh\rh\InstitucionesEducativas;
use Illuminate\Http\Request;
use App\Http\Requests\capacitacionRequest;	
use App\Models\rrhh\edc\vwDesempenios;
use Datatables;
use DB;
use Auth;
use Debugbar;
use Log;
use Excel;
use Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CapacitacionesController extends Controller {

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

    public function index()
	{
		$data = ['title' 			=> 'Plan de Capacitaciones'
				,'subtitle'			=> 'Análisis resultados EDC'
				,'breadcrumb' 		=> [
					['nom'	=>	'Plan de Capacitaciones', 'url' => '#'],
			 		['nom'	=>	'Análisis resultados EDC', 'url' => '#'],
				]]; 
		return view('capacitaciones.analisis.index',$data);
	}
	
	public function show()
	{
		$data = ['title' 			=> 'Plan de Capacitaciones'
				,'subtitle'			=> 'Administrador Capacitaciones'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Index', 'url' => '#'],
				]];

	    $data['eva'] = Evaluaciones::all();
		return view('capacitaciones.capacitacionesAdmin',$data);
	}	
	public function listCapacitaciones(Request $request)
	{
		$cap = DB::connection('sqlsrv')->table(DB::Raw('(Select ROW_NUMBER() OVER(ORDER BY b.nombre ASC) AS row, a.*, b.nombre, b.idEvaluacion as idEva from dnm_rrhh_si.RH.capacitaciones as a inner join dnm_rrhh_si.EDC.evaluaciones as b on a.idEvaluacion = b.idEvaluacion) as temp'))->select('temp.*');

		if(empty($request->get('nombre')) && empty($request->get('evaluacion')) && empty($request->get('fechai')) && empty($request->get('fechaf')) ){
					return Datatables::of($cap)
					->addColumn('editar',function($dt){
						return '<a href="'.url('training/vwDetalleCapacitacion').'/'.$dt->idCapacitacion.'" class="btn btn-sm btn-success"><li class="fa fa-folder-o fa-lg"></li></a>';
					})->make(true);
			}else{
				return Datatables::of($cap)
					->addColumn('editar',function($dt){
						return '<a href="'.url('training/vwDetalleCapacitacion').'/'.$dt->idCapacitacion.'" class="btn btn-sm btn-success"><li class="fa fa-folder-o fa-lg"></li></a>';
					})

					->filter(function($query) use ($request){
	        				if($request->has('nombre')){
	        					$query->where('nombreCapacitacion','like',"%".mb_strtoupper((string)$request->get('nombre'))."%");
	        				}
	        				if($request->has('evaluacion')){
	        					$query->where('idEva','=',(int)$request->get('evaluacion'));
	        				}
	        				if($request->has('fechai')){
	        					$query->where('fechaDesde','=',$request->get('fechai'));
	        				}
	        				if($request->has('fechaf')){
	        					$query->where('fechaHasta','=',$request->get('fechaf'));
	        				}  	  	

	        			})
     
					->make(true);


			}
	}
	public function getEvaluaciones()
	{
		$evals =  Evaluaciones::orderBy('fechaCreacion','desc')->get();

		return response()->json($evals);
	}
	public function crearNueva(capacitacionRequest $request)
	{
		DB::connection('sqlsrv')->beginTransaction();
		$capacitacion = null;
		try {
			if($request->idCapacitacion)
			{
				$capacitacion = capacitacionesModel::where('idCapacitacion',$request->idCapacitacion)->first();				
				$response = ['status' => 200, 'message' => 'Registro editado Exitosamente', "redirect" => ''];
			}
			else
			{
				$capacitacion = new CapacitacionesModel();				
				
			}

			if($capacitacion)
			{

				$capacitacion->nombreCapacitacion = mb_strtoupper($request->nombreCapacitacion,'UTF-8');
				$capacitacion->fechaDesde = date('Y-m-d',strtotime($request->fechaDesde));
				$capacitacion->fechaHasta = date('Y-m-d',strtotime($request->fechaHasta));
				$capacitacion->idEvaluacion = $request->idEvaluacion;
				$capacitacion->idUsuarioCreacion = Auth::user()->idUsuario.'@'.$request->ip();
				$capacitacion->idUsuarioModificacion = Auth::user()->idUsuario.'@'.$request->ip();
				$capacitacion->entidad = $request->entidad;
				$capacitacion->lugar =  mb_strtoupper($request->lugar,'UTF-8');
				$capacitacion->instructor =  mb_strtoupper($request->instructor,'UTF-8');
				$capacitacion->fechaHastaEvaluacion = date('Y-m-d',strtotime($request->fechaHastaEvaluacion));
				if(!$request->evaluar)
				{
					$capacitacion->evaluar = 0;
				}
				else
				{
					$capacitacion->evaluar = $request->evaluar;
				}
				$capacitacion->save();	
				$response = ['status' => 200, 'message' => 'Registro guardado Exitosamente', "redirect" => ''];
				DB::connection('sqlsrv')->commit();	
			}
			else
			{
				$response = ['status' => 500, 'message' => 'No es posible realizar la acción solicitada', "redirect" => ''];				
			}
			
			

		} catch (\Exception $e) {
			Debugbar::addException($e);
			$response = ['status' => 500, 'message' => 'Se produjo una excepción en el servidor', "redirect" => ''];
			DB::connection('sqlsrv')->rollback();
		}
		
		return response()->json($response);
	}



	public function vwDetalleCapacitacion($id)
	{
		$cap = CapacitacionesModel::where('idCapacitacion',$id)->get();
		$data = ['title' 			=> 'Plan de Capacitaciones'
				,'subtitle'			=> 'Administrador Capacitaciones'
				,'cap' => $cap
				,'breadcrumb' 		=> [
					['nom'	=>	'Administrador Capacitaciones', 'url' => route('rh.capacitaciones.admin')],
			 		['nom'	=>	$cap[0]->nombreCapacitacion, 'url' => '#']			 		
				],				
				];
          $institucion =  InstitucionesEducativas::getInstituciones();
          $data['institucion'] = $institucion;

		return view('capacitaciones.detalleCapacitacion',$data);	
	}
	public function getDetalleCapacitacion($id)
	{
		$det = DB::connection('sqlsrv')->table(DB::Raw('(
			SELECT \'Desempeño\' AS tipo, vw.idEmpleado, vw.nombreEmpleado, vw.nombrePlaza, vw.nombreUnidad, vw.nombreEstado,
				CONCAT(\'Funcion: \',vw.nombreFuncion,\'<br><br>Tarea: \',vw.nombreTarea,\'<br><br>Desempeño: \',vw.nombreDesempenio) AS descripcion, vw.accionTomar
			FROM dnm_rrhh_si.RH.detalleCapacitaciones AS a 
			INNER JOIN dnm_rrhh_si.EDC.vwDesempenios AS vw ON a.idDesempenio = vw.idDesempenio 
			WHERE a.idCapacitacion = '.$id.' AND  a.idResultado = vw.idResultado

			UNION ALL

			SELECT \'Producto\' AS tipo, vw.idEmpleado, vw.nombreEmpleado, vw.nombrePlaza, vw.nombreUnidad, vw.nombreEstado,
				CONCAT(\'Funcion: \',vw.nombreFuncion,\'<br><br>Tarea: \',vw.nombreTarea,\'<br><br>Producto: \',vw.nombreProducto) AS descripcion, vw.accionTomar
			FROM dnm_rrhh_si.RH.detalleCapacitaciones AS a 
			INNER JOIN dnm_rrhh_si.EDC.vwProductos AS vw ON a.idProducto = vw.idProducto 
			WHERE a.idCapacitacion = '.$id.' AND  a.idResultado = vw.idResultado

			UNION ALL

			SELECT DISTINCT \'Conocimiento\' AS tipo, vw.idEmpleado, vw.nombreEmpleado, vw.nombrePlaza, vw.nombreUnidad, \'\' AS nombreEstado,
				vw.nombreTipoConocimiento AS descripcion, \'\' AS accionTomar
			FROM dnm_rrhh_si.RH.detalleCapacitaciones AS a 
			INNER JOIN dnm_rrhh_si.EDC.vwConocimientos AS vw ON a.idTipoConocimiento = vw.idTipoConocimiento 
			WHERE a.idCapacitacion = '.$id.' AND  a.idResultado = vw.idResultado

			UNION ALL

			Select 
				DISTINCT 
				\'Actitud\' as tipo,
				vw.idEmpleado,
				vw.nombreEmpleado, 
				vw.nombrePlaza,
				vw.nombreUnidad,
				\'\' AS nombreEstado,
				STUFF(
				 (
					SELECT DISTINCT \', \' +
					vw1.nombreTipoActitud
					FROM dnm_rrhh_si.EDC.vwActitudes AS vw1
					INNER JOIN dnm_rrhh_si.RH.detalleCapacitaciones cap1
					on cap1.idResultado = vw1.idResultado
					where vw1.idTipoActitud = cap1.idTipoActitud
					and cap1.idCapacitacion = '.$id.' and idEmpleado = vw.idEmpleado
					FOR XML PATH(\'\')),1,1,\'\'	 
				) as descripcion,
				\'\' AS accionTomar
			from
			dnm_rrhh_si.RH.detalleCapacitaciones cap
			inner join dnm_rrhh_si.EDC.vwActitudes vw on vw.idResultado = cap.idResultado
			where idCapacitacion = '.$id.' and vw.idTipoActitud = cap.idTipoActitud
		) AS temp'))->select('temp.*');



		return Datatables::of($det)->addColumn('add', function ($dt) {
        			return '';
	            })->make(true);		
	}



//--------------------------------------------------------------------------

	
	public function addDetCapacitaciones(Request $request){

		 $rules = [
            'capacitacion' 	=>  'required|numeric',
            'idResDet'		=>	'required|array|min:1',
            'tipo'			=>	'required|numeric|min:1|max:4'
        ];

        $v = Validator::make($request->all(),$rules);
        //Validaciones de sistema
        $v->setAttributeNames([
            'capacitacion'	=>	'Capacitación',
            'idResDet'		=>	'Detalle items',
            'tipo'			=>	'Tipo evaluado'
        ]);

        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 400, 'message' => $msg]);
        }

        /*
         *      ADICIÓN DE DETALLES
         */
	



        DB::beginTransaction();
        try {
        	$usuario = Auth::user()->idUsuario.'@'.$request->ip();
        	$detName = "";
        	$routeToRedirect = "";
        	switch ($request->tipo) {
        		case '1':
        			$detName = "idDesempenio";
        			$routeToRedirect = "rh.capacitaciones.desempenios";
        			break;
        		case '2':
        			$detName = "idProducto";
        			$routeToRedirect = "rh.capacitaciones.productos";
        			break;
        		case '3':
        			$detName = "idTipoConocimiento";
        			$routeToRedirect = "rh.capacitaciones.conocimientos";
        			break;
        		case '4':
        			$detName = "idTipoActitud";
        			$routeToRedirect = "rh.capacitaciones.actitudes";
        		default:
        			break;
        	}
      
        	foreach ($request->idResDet as $key => $value) {
        		list($resultado,$detVal) = explode('~', $value);
        		//$data = ['idCapacitacion' => $request->capacitacion, 'idResultado' =>  $resultado,$detName => $detVal];
        		$capaDet = CapacitacionesDetalle::where('idCapacitacion',$request->capacitacion)
        			->where('idResultado',$resultado)
        			->where($detName,$detVal)->first();
        		if(empty($capaDet)){
        			$data['idUsuarioCreacion'] = $usuario;
        			$capaDet = new CapacitacionesDetalle;
        			$capaDet->idCapacitacion = $request->capacitacion;
        			$capaDet->idResultado = $resultado;
        			$capaDet->$detName = $detVal;
        			$capaDet->idUsuarioCreacion = $usuario;
        			$capaDet->save();
        		}else{
        			$capaDet->idUsuarioModificacion = $usuario;
        			$capaDet->save();
        		}
        	}        	
        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }  
        DB::commit();
        return response()->json(['status' => 200, 'message' => "¡Registros añadidos exitosamente a la capacitación!", "redirect" => route($routeToRedirect)]);
	}


}