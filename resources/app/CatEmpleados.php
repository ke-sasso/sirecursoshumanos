<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PlazasFuncionales;
use DB;
class CatEmpleados extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.empleados';
    protected $primaryKey = 'idEmpleado';
    const CREATED_AT = 'fechaCreacion';
 	const UPDATED_AT = 'fechaModificacion';
	protected $connection = 'sqlsrv';


     public function documentosPersonal(){
        return $this->hasMany('App\Models\rrhh\rh\DocumentosEmpleado','duiEmpleado','dui');
    }


	public static function getEmpleados(){
     return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.empleados as emple')
        ->join('dnm_rrhh_si.RH.plazasFuncionales as plaza','emple.idPlazaFuncional','=','plaza.idPlazaFuncional')
        ->join('dnm_rrhh_si.RH.unidades as uni', 'plaza.idUnidad', '=','uni.idUnidad')
		->select('emple.dui','emple.nombresEmpleado','emple.apellidosEmpleado','emple.idEmpleado','uni.idUnidad','uni.nombreUnidad','plaza.nombrePlaza','plaza.idPlazaFuncional','emple.idPlazaNominal','emple.contratoId','emple.estadoId');

	}

	public static function getEmpleadosByUnidad($idUnidad){
		if($idUnidad!=null){

			$idPlazas=DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.plazasFuncionales')
					->select('idPlazaFuncional')
					->where('idUnidad',$idUnidad)
					->orderBy('idPlazaFuncional')
					->get();


			$idPlazasF=[];
			if(count($idPlazas)>0){
				for($i=0;$i<count($idPlazas);$i++) {
					$idPlazasF[$i]=$idPlazas[$i]->idPlazaFuncional;
				}
			}

			$empleados=DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.empleados')
						->whereIn('idPlazaFuncional',$idPlazasF)
						->get();

			/*
			$empleados=CatEmpleados::whereIn('idPlazaFuncional',function($query){
				$query->select('idPlazaFuncional')
				->from(with(new PlazasFuncionales)->getTable())
				->where('idUnidad',$idUnidad)})->get();
			*/
			return $empleados;


		}
	}


	public static function getEmpleadosByIdPlazaPadre($idPlazaFuncional){

	 return	DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.empleados as emp')
		->join('dnm_rrhh_si.RH.plazasFuncionales as plaza','emp.idPlazaFuncional','=','plaza.idPlazaFuncional')
		->where('plaza.idPlazaFuncionalPadre',$idPlazaFuncional)->select('emp.*')->get();

	}
	public static function getEmpleadosUnidad($idEmpleado){

	 return	DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.empleados as emp')
		->join('dnm_rrhh_si.RH.plazasFuncionales as plaza','emp.idPlazaFuncional','=','plaza.idPlazaFuncional')
		->join('dnm_rrhh_si.RH.unidades as uni','plaza.idUnidad','=','uni.idUnidad')
		->where('emp.idEmpleado',$idEmpleado)
		->select('plaza.nombrePlaza','uni.nombreUnidad','uni.idUnidad')
		->get();

	}
}
