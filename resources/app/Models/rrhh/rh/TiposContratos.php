<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TiposContratos extends Model {

	protected $table = 'dnm_rrhh_si.RH.tiposContratos';
    protected $primaryKey = 'idTipoContrato';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';	


}