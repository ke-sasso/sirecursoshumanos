<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use App\Models\rrhh\edc\resultados\Resultados;
use DB;
use Auth;
class Empleados extends Model {

	protected $table = 'dnm_rrhh_si.RH.empleados';
    protected $primaryKey = 'idEmpleado';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';

	public function plazaFuncional(){
		return $this->hasOne('App\PlazasFuncionales','idPlazaFuncional','idPlazaFuncional');
	}

	public function getNombreCompleto(){
		return trim($this->nombresEmpleado).' '.trim($this->apellidosEmpleado);
	}

	public function getTextoGenero(){
		switch ($this->sexo) {
			case 'M':
				return 'MASCULINO';
				break;
			case 'F':
				return 'FEMENINO';
				break;
			default:
				return '';
				break;
		}
	}

	public function getTextoNombrePlazaFuncional(){
		$pf = $this->plazaFuncional;
		if(empty($pf)){
			return '';
		}else{
			return $pf->nombrePlaza;
		}
	}

	public function getTextoNombreUnidad(){
		$pf = $this->plazaFuncional;
		if(empty($pf) && empty($pf->unidad)){
			return '';
		}else{
			return   mb_strtoupper($pf->unidad->nombreUnidad, 'UTF-8');
		}
	}

	public function getResultadoByIdEva($idEva){
		return Resultados::where('activo',1)->where('idEvaluacion',$idEva)->where('idEmpleado',$this->idEmpleado)->first();
	}

	public static function findEmpleadoSelectize($query){

        return Empleados::where('nombresEmpleado','LIKE','%'.$query.'%')
        		->orWhere('apellidosEmpleado','LIKE','%'.$query.'%')
                ->select(DB::raw('concat(nombresEmpleado,\', \',apellidosEmpleado) as nombreCompleto'),'idPlazaFuncional')->distinct('nombresEmpleado')
                ->take(10)->get();
    }

    public static function getEmpleadosTemporales(){

    	$idJefe = Auth::user()->idEmpleado;

    	return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.empleados as Emp')
    	->join('dnm_rrhh_si.RH.plazasFuncionales as PF1','Emp.idPlazaFuncional','=','PF1.idPlazaFuncional')
    	->leftjoin('dnm_rrhh_si.RH.plazasFuncionales as PF2', 'PF1.idPlazaFuncionalPadre', '=' ,'PF2.idPlazaFuncional')
    	->leftjoin('dnm_rrhh_si.RH.unidades as uni', 'uni.idUnidad', '=' ,'PF1.idUnidad')
		->leftjoin('dnm_rrhh_si.RH.plazasNominales as nom', 'nom.idPlazaNominal', '=' ,'PF1.idPlazaNominal')
		->where('Emp.contratoId',4)//código para empleados temporales
		->select('Emp.idEmpleado','Emp.nombresEmpleado','Emp.apellidosEmpleado','Emp.fechaInicioPruebas','Emp.fechaFinPruebas','PF1.idPlazaFuncional','PF1.nombrePlaza','PF2.nombrePlaza as plazaPadre', 'nom.nombrePlazaNominal', 'uni.nombreUnidad','PF1.descripcionPlaza','PF1.fechaInicial');

    }
}
