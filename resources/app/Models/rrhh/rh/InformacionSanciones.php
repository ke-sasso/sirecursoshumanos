<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class InformacionSanciones extends Model {

	protected $table = 'dnm_rrhh_si.RH.infoSanciones';
	protected $primaryKey = 'id';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';


}
