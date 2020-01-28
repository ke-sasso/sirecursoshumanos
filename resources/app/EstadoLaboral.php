<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EstadoLaboral extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.estadoLaboral';
    protected $primaryKey = 'idEstadoLabor';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	
	public static function getNextID(){
		$EstadoLaboral = EstadoLaboral::orderBy('idEstadoLabor', 'desc')->first();
		return $EstadoLaboral->idEstadoLabor + 1;
	}

}
