<?php namespace App\Models\rrhh\edc;

use Illuminate\Database\Eloquent\Model;

use DB;

class Evaluaciones extends Model {

	//
	protected $table = 'dnm_rrhh_si.EDC.evaluaciones';
    protected $primaryKey = 'idEvaluacion';
	public $timestamps = false;
	protected $connection = 'sqlsrv';

	public static function getEvaluacionVigente(){
		return Evaluaciones::where('activo',1)->where('fechaInicio','<=',date('Y-m-d'))->where('fechaFin','>=',date('Y-m-d'))->first();
	}
	public static function getEvaluaciones(){
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.EDC.evaluaciones')
		      ->select('idEvaluacion','nombre','periodo','fechaInicio','fechaFin','descripcion','activo');
	}

	public static function getEmpleadosEvaluaciones($idEvaluacion,$request){
      return DB::connection('sqlsrv')->table('dnm_rrhh_si.EDC.resultados as resul')
              ->join('dnm_rrhh_si.RH.empleados as emp','resul.idEmpleado','=','emp.idEmpleado')
              ->join('dnm_rrhh_si.RH.plazasFuncionales as pf','emp.idPlazaFuncional','=','pf.idPlazaFuncional')
              ->join('dnm_rrhh_si.RH.empleados as empl','resul.idPlazaFuncional','=','empl.idPlazaFuncional')
              ->join('dnm_rrhh_si.RH.unidades as uni','pf.idUnidad','=','uni.idUnidad')
		      ->select('emp.idPlazaFuncional as plazaFuncional','resul.finalizada','resul.aprobada','resul.idPlazaFuncional','resul.fechaEvaluacion','resul.CP','resul.idEmpleado','emp.nombresEmpleado','emp.apellidosEmpleado','uni.nombreUnidad','uni.idUnidad','emp.dui',DB::raw("CONVERT( VARCHAR(MAX),resul.comentarios)as comentario"))
		      ->where(function($query) use ($request){
		      	if($request->finalizada <> '')
		      	{
		      		$query->where('finalizada',$request->finalizada);
		      	}
		      	else
		      	{
		      		$query->where('finalizada',1);
		      	}
		      })		      
		      ->where(function($query) use ($request){
		      		if($request->has('fechaInicio')){ 	
	        					$query->where(DB::raw('Convert(varchar(10), fechaEvaluacion,120)'),'=',date('Y-m-d',strtotime(str_replace("/","-",$request->get('fechaInicio')))));
	        			}

	        			if($request->has('unidad')){
	        					$query->where('uni.idUnidad','=',$request->get('unidad'));
	        				}
                        if($request->has('codigo')){

	        					$query->where('resul.idEmpleado','=',$request->get('codigo'));
	        				}
                          if($request->has('nombre')){
                          
	        					$query->where('emp.nombresEmpleado','like',"%".mb_strtoupper((string)$request->get('nombre'))."%");

	        				}
                        if($request->has('apellido')){
                             
	        					$query->where('emp.apellidosEmpleado','like',"%".mb_strtoupper((string)$request->get('apellido'))."%");

	        				}
                        if($request->has('nombre') && $request->has('apellido')){
                              //   ->where('nombre_comercial','like',"%".(string)$request->get('nombre_comercial')."%")
	        					$query->where('emp.apellidosEmpleado','like',"%".mb_strtoupper((string)$request->get('apellido'))."%")
	        					->where('emp.nombresEmpleado','like',"%".mb_strtoupper((string)$request->get('nombre'))."%");

	        				}
                	
		      })
		      ->where('resul.idEvaluacion',$idEvaluacion)->distinct()->get();


	}


	public static function getDataHistorial($idEmp = null){
		if(empty($idEmp)){
			DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.vwEvaluacionesHistorial as eva');
			/*
			return DB::connection('sqlsrv')->table('dnm_rrhh_si.EDC.evaluaciones as e')
				->join('dnm_rrhh_si.EDC.resultados as r','r.idEvaluacion','=','e.idEvaluacion')
				->join('dnm_rrhh_si.EDC.resultadosEstados as re','re.idEstado','=','r.idEstado')
				->join('dnm_rrhh_si.RH.empleados as emp','emp.idEmpleado','=','r.idEmpleado')
				->join('dnm_rrhh_si.RH.plazasFuncionales as pf','pf.idPlazaFuncional','=','r.idPlazaFuncional')
				->where('e.activo',0)->orderBy('e.idEvaluacion')
				->select(['e.idEvaluacion','e.nombre','e.periodo', 'emp.nombresEmpleado', 'emp.apellidosEmpleado','pf.nombrePlaza','r.idResultado','re.nombreEstado','r.CP','r.sumTotales','r.sumParciales','r.sumMinimas']);
				*/
		}else{
			DB::connection('sqlsrv')->table('dnm_rrhh_si.Permisos.vwEvaluacionesHistorial as eva')->where('idEmpleado',$idEmp);
			/*
			return DB::connection('sqlsrv')->table('dnm_rrhh_si.EDC.evaluaciones as e')
				->join('dnm_rrhh_si.EDC.resultados as r','r.idEvaluacion','=','e.idEvaluacion')
				->join('dnm_rrhh_si.EDC.resultadosEstados as re','re.idEstado','=','r.idEstado')
				->join('dnm_rrhh_si.RH.empleados as emp','emp.idEmpleado','=','r.idEmpleado')
				->join('dnm_rrhh_si.RH.plazasFuncionales as pf','pf.idPlazaFuncional','=','r.idPlazaFuncional')
				->where('e.activo',0)->where('r.idEmpleado',$idEmp)->orderBy('e.idEvaluacion')
				->select(['e.idEvaluacion','e.nombre','e.periodo', 'emp.nombresEmpleado', 'emp.apellidosEmpleado','pf.nombrePlaza','r.idResultado','re.nombreEstado','r.CP','r.sumTotales','r.sumParciales','r.sumMinimas']);
				*/
		}
	}

	public static function getEvaluacionHistorial($idEmp = null){ 
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.EDC.vwEvaluacionesHistorial as his')
					->join('dnm_rrhh_si.EDC.evaluaciones as eva','his.idEvaluacion','eva.idEvaluacion')
					//->join('dnm_rrhh_si.RH.empleados as e','e.idPlazaFuncional','his.idPlazaFuncional')
					->select('his.idEvaluacion','his.nombre','his.periodo','his.idEmpleado','his.nombreUnidad','his.CP','eva.fechaCreacion','his.idResultado')
					->where('his.idEmpleado',$idEmp)->orderBy('his.idResultado')->distinct()->get();
		
	}
}
