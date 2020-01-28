<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class Parentesco extends Model {

	protected $table = 'dnm_rrhh_si.RH.parentescos';
	protected $primaryKey = 'idParentesco';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

}