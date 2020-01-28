<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class DocumentosEmpleado extends Model {

	protected $table = 'dnm_rrhh_si.RH.documentosEmpleado';
	protected $primaryKey = 'idDoc';
	protected $connection = 'sqlsrv';
	public $incrementing = false;
	const CREATED_AT = 'fechaCreacion';
    const UPDATED_AT = 'fechaModificacion';



}
