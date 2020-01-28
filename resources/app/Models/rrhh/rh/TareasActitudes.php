<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TareasActitudes extends Model {

	protected $table = 'dnm_rrhh_si.RH.funcionesTareasActitudes';
    protected $primaryKey = 'idActitud';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';	

	public function scopeActivas(){
		return $this->where('activo',1);
	}

	public function tipoActitud(){
		return $this->hasOne('App\Models\rrhh\rh\TiposActitudes','idTipoActitud','idTipoActitud');
	}
}
