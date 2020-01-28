<?php namespace App\Models\rrhh\edc;

use Illuminate\Database\Eloquent\Model;

class CapacitacionesModel extends Model {

	protected $table = 'dnm_rrhh_si.RH.capacitaciones';
    protected $primaryKey = 'idCapacitacion';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';
	protected $connection = 'sqlsrv';


	protected function getDateFormat()
	{
		return 'Y-m-d';
	}

	public static function getCmbData(){
		$result = "";
		foreach (capacitacionesModel::where('estado',1)->get() as $r) {
			$result.= "<option value='$r->idCapacitacion'>$r->nombreCapacitacion</option>";
		}
		return $result;
	}

}
