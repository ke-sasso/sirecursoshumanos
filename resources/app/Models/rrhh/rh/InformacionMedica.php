<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class InformacionMedica extends Model {

	protected $table = 'dnm_rrhh_si.RH.infoMedica';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $connection = 'sqlsrv';



	public static function getList($dui)
	{
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.infoMedica as med')
			->join('dnm_rrhh_si.RH.grupoSanguineo as gsan','med.tipoSangre','=','gsan.idGrupo')
			->where('med.duiEmpleado',$dui)
			->select('med.id','med.alergias','med.medicamentoPermanente as medi','med.tipoSangre','gsan.nombreGrupo as grupo')
		   ->get();
	}
}
