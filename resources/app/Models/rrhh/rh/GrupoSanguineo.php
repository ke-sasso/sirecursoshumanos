<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class GrupoSanguineo extends Model {

	protected $table = 'dnm_rrhh_si.RH.grupoSanguineo';
	protected $primaryKey = 'idGrupo';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	

	public static function getList()
	{
		return GrupoSanguineo::pluck('nombreGrupo','idGrupo');
	}

}