<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class TipoEstudio extends Model {

	protected $table = 'dnm_rrhh_si.RH.tiposEstudios';
	protected $primaryKey = 'idTipo';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function getNextID(){
		$tipoEst = TipoEstudio::orderBy('idTipo', 'desc')->first();
		return $tipoEst->idTipo + 1;
	}

}