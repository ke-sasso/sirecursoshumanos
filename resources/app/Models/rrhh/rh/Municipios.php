<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model {

	protected $table = 'dnm_catalogos.cat.municipios';
    protected $primaryKey = 'idMunicipio';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';

		public static function getList($idDepartamento)
	{
		return Municipios::where('idDepartamento',$idDepartamento)->pluck('nombreMunicipio','idMunicipio');
	}



}
