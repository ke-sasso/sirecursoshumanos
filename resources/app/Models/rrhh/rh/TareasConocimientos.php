<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TareasConocimientos extends Model {

	protected $table = 'dnm_rrhh_si.RH.funcionesTareasConocimientos';
    protected $primaryKey = 'idConocimiento';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function scopeActivos(){
		return $this->where('activo',1);
	}

	public function tipoConocimiento(){
		return $this->hasOne('App\Models\rrhh\rh\TiposConocimientos','idTipoConocimiento','idTipoConocimiento');
	}

	public function nivel(){
		return $this->hasOne('App\Models\rrhh\rh\ConocimientosNiveles','idNivel','idNivel');
	}
}
