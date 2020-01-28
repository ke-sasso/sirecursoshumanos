<?php namespace App\Http\Controllers;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\SeguroRequest;
use Session;
use Redirect;
use App\CatEmpleados;
use App\Models\rrhh\MarcasEmpleado;
use App\SolLicencia;
use App\SolNoMarcacion;
use App\SolSeguro;
use Mail;
use App\VwPermisos;
use App\Models\rrhh\VwAllPermisos;
use Yajra\Datatables\Datatables;
use App\User;
use App\SolicitudMotivo;
use App\Unidades;
use App\CatMotivos;
use App\CatJefes;
use App\Models\rrhh\CatDependientes;
use App\Models\rrhh\CatEnfermedades;
use App\Http\Controllers\InicioController;
use App\Models\rrhh\CapitulosEnfermedades;
use App\Models\rrhh\DocumentoSeguro;
use File;
use Crypt;
use Carbon\Carbon;
use Response;
use DateTime;


class PermisosController extends Controller {

	public function __construct(){
        $this->middleware('auth');
    }




    public function getSeguros(){
		$data = ['title' 			=> 'SOLICITUDES DE SEGUROS'
				,'subtitle'			=> '>EMPLEADOS'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Solicitudes', 'url' => '#'],
			 		['nom'	=>	'Seguros', 'url' => '#']
				]]; 

	  $data['unidades']=Unidades::all();
	  $data['motivos']=CatMotivos::where('idMotivo',5)
	    ->orWhere('idMotivo', 33)
	    ->orWhere('idMotivo', 4)
	    ->orWhere('idMotivo', 32)
	    ->orWhere('idMotivo', 34)
	    ->orWhere('idMotivo', 29)
	    ->orWhere('idMotivo', 30)
	    ->get();
		return view('solicitudes.permisos.solicitudesSeguro',$data);

	}

	public function getLicencias(){
		$data = ['title' 			=> 'SOLICITUDES DE LICENCIA'
				,'subtitle'			=> '>EMPLEADOS'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Solicitudes', 'url' => '#'],
			 		['nom'	=>	'Licencias', 'url' => '#']
				]]; 

		$data['usuario']= Auth::user()->idUsuario;
		$data['unidades']=Unidades::all();

	
		return view('solicitudes.permisos.solicitudesLicencia',$data);

	}
   
   public function getDataRowsSeguros(Request $request){
   		//dd($request->all());
		$seguros=SolSeguro::getSolicitudesSeguro();
		if(empty($request->get('unidad')) && empty($request->get('fechaInicio')) && empty($request->get('procesada')) && empty($request->get('tipo'))){

			return Datatables::of($seguros)

			->addColumn('detalle', function ($dt) {

						return	'<a href="'.route('ver.seguro',['idSolSeguro' =>Crypt::encrypt($dt->idSolSeguro)]).'" class="btn btn-xs btn-success btn-perspective"><i class="fa fa-plus-square" aria-hidden="true"></i></a>';
                        
					 			
						})

			->addColumn('nombreEstado',function($dt){
						if($dt->idEstadoSeguro == 1)
							return '<span class="label label-success "> '.$dt->nombreEstado.'<i class="fa fa-check"></span>';
						else if($dt->idEstadoSeguro== 2)
							return '<span class="label label-info">'.$dt->nombreEstado.'<i class="fa fa-check-circle"></span>';
						else if($dt->idEstadoSeguro == 3)
							return '<span class="label label-success">'.$dt->nombreEstado.'<i class="fa fa-ckeck"></span>';
						else if($dt->idEstadoSeguro== 4)
							return '<span class="label label-success">'.$dt->nombreEstado.'<i class="fa-check-circle"></span>';
						else if($dt->idEstadoSeguro== 5)
							return '<span class="label label-warning">'.$dt->nombreEstado.'<i class="fa fa-check-circle"></span>';
						else if($dt->idEstadoSeguro == 6)
							return '<span class="label label-danger">'.$dt->nombreEstado.'<i class="fa fa-times"></span>';
					
					})
			->make(true);
		}else{
		return Datatables::of($seguros)

			->addColumn('detalle', function ($dt) {

						return	'<a href="'.route('ver.seguro',['idSolSeguro' =>Crypt::encrypt($dt->idSolSeguro)]).'" class="btn btn-xs btn-success btn-perspective"><i class="fa fa-plus-square" aria-hidden="true"></i></a>';
                        
					 			
						})

			->addColumn('nombreEstado',function($dt){
						if($dt->idEstadoSeguro == 1)
							return '<span class="label label-success "> '.$dt->nombreEstado.'<i class="fa fa-check"></span>';
						else if($dt->idEstadoSeguro== 2)
							return '<span class="label label-info">'.$dt->nombreEstado.'<i class="fa fa-check-circle"></span>';
						else if($dt->idEstadoSeguro == 3)
							return '<span class="label label-success">'.$dt->nombreEstado.'<i class="fa fa-ckeck"></span>';
						else if($dt->idEstadoSeguro== 4)
							return '<span class="label label-success">'.$dt->nombreEstado.'<i class="fa-check-circle"></span>';
						else if($dt->idEstadoSeguro== 5)
							return '<span class="label label-warning">'.$dt->nombreEstado.'<i class="fa fa-check-circle"></span>';
						else if($dt->idEstadoSeguro == 6)
							return '<span class="label label-danger">'.$dt->nombreEstado.'<i class="fa fa-times"></span>';
					
					})
          
               ->filter(function($query) use ($request){
							
	        				if($request->has('unidad')){
	        					$query->where('uni.idUnidad','=',(int)$request->get('unidad'));
	        				}
	        				
	        				if($request->has('fechaInicio')){ 	
	        					$query->where(DB::raw('Convert(varchar(10), se.fechaCreacion,120)'),'=',date('Y-m-d',strtotime(str_replace("/","-",$request->get('fechaInicio')))));
	        				}

	        				if($request->has('procesada')){
	        					$query->where('se.idEstadoSeguro','=',(int)$request->get('procesada'));
	        				}
	        				if($request->has('tipo')){
	        					$query->where('se.idMotivo','=',(int)$request->get('tipo'));
	        				}
							

	        			})
     
			->make(true);
		}
	
	}
	public function getDataRowsLicencias(Request $request){
		session::forget("msnExito");
		
		$solicitudes=DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.vwPermisosRrhh as permisos')
					->whereIn('idEstadoSol',[3,4,6]);

      
		
		return Datatables::of($solicitudes)

					->addColumn('estadoSol',function($dt){
						if($dt->idEstadoSol == 1)
							return '<span class="label label-info">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 2)
							return '<span class="label label-danger">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 3)
							return '<span class="label label-success">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 4)
							return '<span class="label label-success">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 5)
							return '<span class="label label-warning">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 6)
							return '<span class="label label-primary">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 7)
							return '<span class="label label-danger">'.$dt->nombreEstado.'</span>';	

					})


					->addColumn('procesado', function ($dt) {
						 if($dt->procesada==0){
	                  		return '<button class="btn btn-danger btn-xs" id="NoProcesar" onclick="NoProcesar('.$dt->idTipo.','.$dt->id.',2)">
	                  	NO PROCESAR</button>'.' '.'<button class="btn btn-primary btn-xs" id="NoProcesar" onclick="NoProcesar('.$dt->idTipo.','.$dt->id.',1)">
	                  	PROCESAR <i class="fa fa-refresh" aria-hidden="true"></i></button>';
	             		}
	             		elseif($dt->procesada==1){
	             			return '<a href="" class="btn btn-xs btn-info btn-perspective">PROCESADA<i class="fa fa-check" aria-hidden="true"></i></a>';
	             		}
	             		elseif($dt->procesada==2){
	             			return '<a href="" class="btn btn-xs btn-danger btn-perspective">NO PROCESADA<i class="fa fa-times" aria-hidden="true"></i></a>';
	             		}
					})


					->addColumn('detalle', function ($dt) {
	            	    
	              return	'<a href="'.route('ver.solicitud.Licencia',['idTipo' =>Crypt::encrypt($dt->idTipo),'idSolicitud' => Crypt::encrypt($dt->id)]).'" class="btn btn-xs btn-success btn-perspective" ><i class="fa fa-search"></i></a>';
	             
					})

		->filter(function($query) use ($request){
						  
	        				if($request->has('unidad')){
	        					$query->where('idUnidad','=',$request->get('unidad'));
	        				}
							if($request->has('fechaInicio') and $request->has('fechaFin')){ 	

	        					$query->whereBetween('fechaCreacion',[$request->get('fechaInicio'),$request->get('fechaFin')]);
	        				
	        				}elseif($request->has('fechaInicio')){ 	
	        				
	        					$query->where('fechaCreacion','=',$request->get('fechaInicio'));

	        				}

	        				if($request->has('procesada')){
	        					$query->where('procesada','=',(int)$request->get('procesada'));
	        				}
	        				if($request->has('tipo')){
	        					$query->where('idTipo','=',(int)$request->get('tipo'));
	        				}

                  
	        			})
					->make(true);	
		
	}
	public function procesarRrhh(Request $request){
		//dd($request->all());

		//si es tipo 1, SolNoMarcacion
		
		if($request->idTipo==1){
			$solnomarcacion=SolNoMarcacion::find($request->idSolicitud);
			$solnomarcacion->procesada=$request->accion;
			if($solnomarcacion->save()){
				return response()->json(['status' => 200, 'message' => "Su solicitud ha sido procesada"]);	
			}
			else{
				return response()->json(['status' => 400, 'message' => "No se ha podido procesar la solicitud"]);		
			}
			
		}
		//si es tipo 2, SolLicencia
		elseif($request->idTipo==2){
			$sollicencia=SolLicencia::find($request->idSolicitud);
			$sollicencia->procesada=$request->accion;
			if($sollicencia->save()){
				return response()->json(['status' => 200, 'message' => "Su solicitud ha sido procesada"]);	
			}
			else{
				return response()->json(['status' => 400, 'message' => "No se ha podido procesar la solicitud"]);
			}
			
		}
		
	}

		public function procesarLicencia($idTipo,$idSolicitud){
		
		//si es tipo 1, SolNoMarcacion
		if($idTipo==1){
			$solnomarcacion=SolNoMarcacion::find($idSolicitud);
			$solnomarcacion->procesada=1;
			$solnomarcacion->save();
        
		   Session::put('msnExito', '¡LA SOLICITUD FUE PROCESADA CON EXITO!');
		 return redirect()->route('all.licencias');
		 
		//return back();
		}
		//si es tipo 1, SolLicencia
		elseif($idTipo==2){
			$sollicencia=SolLicencia::find($idSolicitud);
			$sollicencia->procesada=1;
			$sollicencia->save();
			 Session::put('msnExito', '¡LA SOLICITUD FUE PROCESADA CON EXITO!');
	
					    	
					return redirect()->route('all.licencias');
		//return back();
		}
		
	}
		public function mostrarLicencia($idTipo,$idSolicitud){
		
		//dd($tipo);
			$idTipo=Crypt::decrypt($idTipo);
         $idSolicitud=Crypt::decrypt($idSolicitud);
		if($idTipo==1){
			return $this->showNoMarcacion($idSolicitud);
							
		}
		elseif(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==20 || CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==19){
			if($idTipo==2){
				return $this->showLicenciaAutorizar($idSolicitud);
			}
		}
		elseif($idTipo==2){
			//return 'hola';
			return $this->showLicencia($idSolicitud);
		}
		
	}
	public function showLicencia($idSolicitud)
	{	
		//
		$data = ['title' 			=> 'Permisos: '
				,'subtitle'			=> 'Solicitudes'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Regresar a solicitudes licencia', 'url' => route('all.licencias')],
			 		['nom'	=>	'Solicitud de licencia', 'url' => '#']
				]]; 

		$solicitud=SolLicencia::find($idSolicitud);
		//dd($solicitud);
		$empleado=CatEmpleados::find($solicitud->idEmpleadoCrea);
		$unidad=Unidades::getUnidadByIdEmpleado($empleado->idEmpleado);
		$motivos=SolicitudMotivo::getMotivosBySolicitud(2);
		$data['motivos']=$motivos;
		$data['solicitud']=$solicitud;
		$data['empleado']=$empleado;
		$data['unidad']=$unidad;
		$autorizar = CatJefes::where('idPlazaFuncional',CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional)->first();
		if($autorizar!=null)
			$data['autorizar']=1;
		else
			$data['autorizar']=0;
		//dd($data);
		return view('solicitudes.permisos.showlicencia',$data);
	}
		public function showLicenciaAutorizar($idSolicitud)
	{	
		//
		$data = ['title' 			=> 'Permisos: '
				,'subtitle'			=> 'Solicitudes'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Permisos y Seguro', 'url' => '#'],
			 		['nom'	=>	'Permisos', 'url' => '#']
				]]; 
		$solicitud=SolLicencia::find($idSolicitud);
		//dd($solicitud);
		$empleado=CatEmpleados::find($solicitud->idEmpleadoCrea);
		$unidad=Unidades::getUnidadByIdEmpleado($empleado->idEmpleado);
		$motivos=SolicitudMotivo::getMotivosBySolicitud(2);
		$data['motivos']=$motivos;
		$data['solicitud']=$solicitud;
		$data['empleado']=$empleado;
		$data['unidad']=$unidad;
		$autorizar = CatJefes::where('idPlazaFuncional',CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional)->first();
		if($autorizar!=null)
			$data['autorizar']=1;
		else
			$data['autorizar']=0;
		//dd($data);
		return view('solicitudes.permisos.showlicenciadirector',$data);
	}

	public function autorizacionSuperior(Request $request){
		//dd($request->all());
		if(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==20){
			$solnomarcacion=SolLicencia::find($request->idSolicitud);
			$solnomarcacion->autorizacion1=Auth::user()->idEmpleado;
			$solnomarcacion->idEstado=6;
			$solnomarcacion->save();
			return redirect()->route('all.licencias.director');
		}
		elseif(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==19){
			$solnomarcacion=SolLicencia::find($request->idSolicitud);
			$solnomarcacion->autorizacion1=Auth::user()->idEmpleado;
			$solnomarcacion->idEstado=4;
			$solnomarcacion->save();
			return redirect()->route('all.licencias.director');
			//dd($solnomarcacion);
		}
	}
	public function solicitudesLicenciaDirector(){
		
		$data = ['title' 			=> 'Permisos y Seguro'
				,'subtitle'			=> 'Listado de licencias'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Permisos y Seguro', 'url' => '#'],
			 		['nom'	=>	'Licencias a Autorizar', 'url' => '#']
				]]; 
		//*/
		
		return view('solicitudes.permisos.licenciasAutorizar',$data);
	}

	public function getDataRowsLicenciaDirector(){
		if(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==20){
			$licencias=SolLicencia::getLicenciaDirector();	
		}
		elseif(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==19){
			$licencias=SolLicencia::getLicenciasNivel2();
		}
		elseif(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==25){
			$licencias=VwAllPermisos::where('idPlazaFuncionalPadre',25)->get();
		}
		return Datatables::of($licencias)
				->addColumn('tipo', function ($dt) {
							if($dt->idTipo==1){
								return	'NO MARCACIÓN';	
							}
							elseif($dt->idTipo==2){
								return	'LICENCIA';	
							}
						})
				->addColumn('estadoSol',function($dt){
						if($dt->idEstadoSol == 1)
							return '<span class="label label-info">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 2)
							return '<span class="label label-danger">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 3)
							return '<span class="label label-success">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 4)
							return '<span class="label label-success">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 5)
							return '<span class="label label-warning">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 6)
							return '<span class="label label-primary">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 7)
							return '<span class="label label-danger">'.$dt->nombreEstado.'</span>';

					})
					->addColumn('detalle', function ($dt) {
	                	return	'<a href="'.route('ver.solicitud',['idTipo' =>$dt->idTipo,'idSolicitud' => $dt->idSolLicencia]).'" class="btn btn-xs btn-success btn-perspective"><i class="fa fa-search"></i></a>';
	             
					})
				->make(true);
	}

	public function denegar(Request $request){
		//dd($request->all());
		if($request->idTipo==1){
			$solnomarcacion=SolNoMarcacion::find($request->idSolicitud);
			$solnomarcacion->autorizacion1=Auth::user()->idEmpleado;
			$solnomarcacion->idEstado=2;
			//$solnomarcacion->fechaModificacion=date('Y-m-d H:i:s.000');
			$solnomarcacion->save();
			return response()->json(['status' => 200,'message' => "La solicitud ha sido denegada"]);	
		}
		elseif($request->idTipo==2){
			$sollicencia=SolLicencia::find($request->idSolicitud);
			$sollicencia->autorizacion1=Auth::user()->idEmpleado;
			$sollicencia->idEstado=2;
			//$solnomarcacion->fechaModificacion=date('Y-m-d H:i:s.000');
			$sollicencia->save();
			return response()->json(['status' => 200,'message' => "La solicitud ha sido denegada"]);	
		}
		
	}




      public function showNoMarcacion($idSolicitud)
	{
		$solicitud=SolNoMarcacion::find($idSolicitud);
		$empleado=CatEmpleados::find($solicitud->idEmpleadoCrea);
		$unidad=Unidades::getUnidadByIdEmpleado($empleado->idEmpleado);
		
		$data = ['title' 			=> 'Permisos: '
				,'subtitle'			=> 'Solicitudes'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Regresar a solicitudes Licencia', 'url' => route('all.licencias')],
			 		['nom'	=>	'Solicitud no marcación', 'url' => '#']
				]]; 

		//$data['solicitud']=$solicitud;
		$data['empleado']=$empleado;
		$data['unidad']=$unidad;

		$autorizar =CatJefes::where('idPlazaFuncional',CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional)->first();
	//	dd($autorizar);
		if($autorizar!=null)
			$data['autorizar']=1;
		else
			$data['autorizar']=0;
		
		$sol=DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.solicitudNoMarcacion')->where('idSolNoMarca','=',$idSolicitud)->first();
		$data['solicitud']=$sol;
		//dd($sol->horaSalida);
		//dd(date('Y-d-m',strtotime($solicitud->fechaCreacion)));
		return view('solicitudes.permisos.shownomarcacion',$data);
	}

		public function autorizacion(Request $request){
		//dd($request->all());
		//dd(Auth::user()->idEmpleado);
		if($request->tipoPermiso==1){
			$solnomarcacion=SolNoMarcacion::find($request->idSolicitud);
			$solnomarcacion->autorizacion1=Auth::user()->idEmpleado;
			$solnomarcacion->idEstado=3;
			//$solnomarcacion->fechaModificacion=date('Y-m-d H:i:s.000');
			$solnomarcacion->save();
			//dd($solnomarcacion);
			if(CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==19 or CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional==20){
				return redirect()->route('all.licencias.director');
			}
			else{
				return redirect()->route('all.permisos.unidad');
			}
			//return redirect()->route('all.permisos.unidad');
		}
		elseif($request->tipoPermiso==2){
			$solnomarcacion=SolLicencia::find($request->idSolicitud);
			$solnomarcacion->autorizacion1=Auth::user()->idEmpleado;
			$solnomarcacion->idEstado=3;
			//$solnomarcacion->fechaModificacion=date('Y-m-d H:i:s.000');
			$solnomarcacion->save();
			//dd($solnomarcacion);
			return redirect()->route('all.permisos.unidad');
		}
	}

	public function getSolicitudesByUnidad(){
		$data = ['title' 			=> 'Permisos y Seguro'
				,'subtitle'			=> 'Solicitudes de la Unidad'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Permisos y Seguro', 'url' => '#'],
			 		['nom'	=>	'Solicitudes de la Unidad', 'url' => '#']
				]]; 

		$data['usuario']= Auth::user()->idUsuario;
		//return $data;
		return view('solicitudes.permisos.solicitudesUnidad',$data);

	}

	public function getDataRowsSolicitudesByUnidad(){
		//$unidad=Unidades::getUnidadByIdEmpleado(Auth::user()->idEmpleado);
		$idPlazaFuncional=CatEmpleados::find(Auth::user()->idEmpleado)->idPlazaFuncional;
		$empleados=CatEmpleados::getEmpleadosByIdPlazaPadre($idPlazaFuncional);
		//dd($empleados);
		
		$idEmpleados=[];
			if(count($empleados)>0){
				for($i=0;$i<count($empleados);$i++) {
					if($empleados[$i]->idEmpleado!=Auth::user()->idEmpleado){
						$idEmpleados[$i]=$empleados[$i]->idEmpleado;
					}
				}
			}
        				
		$solicitudes=DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.vwPermisosRrhh as permisos')
					->select(DB::raw('ROW_NUMBER() OVER(ORDER BY permisos.id ASC) AS Row#'),'permisos.*')
					//->whereNotIn('idMotivo',[26])
					->whereIn('idEmpleadoCrea',$idEmpleados);
		
		//dd($solicitudes);
		return Datatables::of($solicitudes)
					->addColumn('estadoSol',function($dt){
						if($dt->idEstadoSol == 1)
							return '<span class="label label-info">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 2)
							return '<span class="label label-danger">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 3)
							return '<span class="label label-success">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 4)
							return '<span class="label label-success">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 5)
							return '<span class="label label-warning">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 6)
							return '<span class="label label-primary">'.$dt->nombreEstado.'</span>';
						else if($dt->idEstadoSol == 7)
							return '<span class="label label-danger">'.$dt->nombreEstado.'</span>';

					})
					->addColumn('detalle', function ($dt) {
	                	return	'<a href="'.route('ver.solicitud',['idTipo' =>$dt->idTipo,'idSolicitud' => $dt->id]).'" class="btn btn-xs btn-success btn-perspective"><i class="fa fa-search"></i></a>';
	             
					})
					->make(true);	
		
	}
	

public function mostrarSeguro($idSolSeguro)
	{
		$solseguro=DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.solicitudSeguros')
		->where('idSolSeguro',Crypt::decrypt($idSolSeguro))->first();
		if($solseguro->idDependiente==0){
			$asegurado=CatEmpleados::find($solseguro->idAsegurado);
			$presentado=$asegurado->nombresEmpleado.' '.$asegurado->apellidosEmpleado;
		}
		elseif($solseguro->idAsegurado==0){
			$depen=CatDependientes::find($solseguro->idDependiente);
			$presentado=$depen->nombres;
		}		
		$motivos=SolicitudMotivo::getMotivosBySolicitud(1);
		$documento=DocumentoSeguro::where('idSolSeguro',$solseguro->idSolSeguro)->first();
		$data = ['title' 			=> 'SOLICITUD DEL SEGURO'
				,'subtitle'			=> '>EMPLEADO'
				,'breadcrumb' 		=> [

			 		['nom'	=>	'Regresar a solicitudes', 'url' =>  route('all.seguros')],
			 		['nom'	=>	'Solicitud del empleado', 'url' => '#']
				]]; 
		$data['motivos']=$motivos;
        $data['presentado']=$presentado;
		$data['solicitud']=$solseguro;
		$data['documento']=$documento;
		return view('solicitudes.permisos.mostrarSeguro',$data);
	}

public function getEnfermedades(Request $request){

		$enfermedades= DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.enfermedades')->where('idCapitulo',$request->capitulo)->get();
		return response()->json(['status' => 200,'message' => "",'data' => $enfermedades]);
		
	}


public function download($urlDocumento){
      //dd($tipoDocumento);

     if($urlDocumento!=""){

		$urlDocumento=Crypt::decrypt($urlDocumento);   
		$documento=DocumentoSeguro::where('urlDocumento',$urlDocumento)->first();
        
		$tipoArchivo=trim($documento->tipoDocumento);
		
		if($tipoArchivo=='application/pdf'){		
								if (File::isFile($urlDocumento))
								{

									try {
											    $file = File::get($urlDocumento);
											    $response = Response::make($file, 200);			    
											    $response->header('Content-Type', 'application/pdf');

											    return $response;
								     } catch (Exception $e) {
                                            
										    return Response::download(trim($urlDocumento));
								     }
								}else{
									return back();
								}
		}else if($tipoArchivo=='image/png' or $tipoArchivo==='image/jpeg'){
									if (File::isFile($urlDocumento))
									{
									
									    $file = File::get($urlDocumento);
									    $response = Response::make($file, 200);
									    // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
									     $content_types = [
						                'image/png', // png etc
						                'image/jpeg', // jpeg
						                  ];
									    $response->header('Content-Type', $content_types);

									    return $response;
									}else{
										//REToRNA A LA VISTA SI NO EXISTE ESE ARCHIVO
									return back();
								    }
			}else{

							if (File::isFile($urlDocumento))
							{	
					
							    return Response::download(trim($urlDocumento));
							}
		}

	}

	}//cierre del metodo




}