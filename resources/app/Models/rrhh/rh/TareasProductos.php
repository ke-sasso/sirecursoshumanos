<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TareasProductos extends Model {

	protected $table = 'dnm_rrhh_si.RH.funcionesTareasProductos';
    protected $primaryKey = 'idProducto';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public function scopeActivos(){
		return $this->where('activo',1);
	}

}
