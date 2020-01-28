<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TareasDesempenios extends Model {

	protected $table = 'dnm_rrhh_si.RH.funcionesTareasDesempenios';
    protected $primaryKey = 'idDesempenio';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function scopeActivos(){
		return $this->where('activo',1);
	}
}
