<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model {

	protected $table = 'dnm_catalogos.cat.departamento';
    protected $primaryKey = 'idDepartamento';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';

		public static function getList()
	{
		return Departamentos::where('idPais',222)->pluck('nombreDepartamento','idDepartamento');
	}


}
