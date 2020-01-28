<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class ConocimientosNiveles extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.conocimientoNiveles';
    protected $primaryKey = 'idNivel';
	public $timestamps = false;
	protected $connection = 'sqlsrv';


}