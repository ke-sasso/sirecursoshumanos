<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class HistorialLaboral extends Model {

	protected $table = 'dnm_rrhh_si.RH.historialLaboral';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $connection = 'sqlsrv';


	public static function getListHistorialEmpleado($dui)
	{
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.historialLaboral as T1')
			->join('dnm_rrhh_si.RH.plazasFuncionales as T2','T1.plaza','=','T2.idPlazaFuncional')
			->join('dnm_rrhh_si.RH.unidades as T3','T1.unidad','=','T3.idUnidad')
			->where('T1.duiEmpleado','=',$dui)
			->where('T1.estado','=','A')
			->select('T1.id','T2.nombrePlaza','T3.nombreUnidad','T1.fechaInicio','T1.fechaFin','T1.observacion')
		   ->get();
	}

}
