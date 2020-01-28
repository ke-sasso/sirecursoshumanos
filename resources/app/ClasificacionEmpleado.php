<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClasificacionEmpleado extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.clasificacionApoyo';
    protected $primaryKey = 'idClasificacion';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	
	public static function getNextID(){
		$clEmpleado = ClasificacionEmpleado::orderBy('idClasificacion', 'desc')->first();
		return $clEmpleado->idClasificacion + 1;
	}

}
