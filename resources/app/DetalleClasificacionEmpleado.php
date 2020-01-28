<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Auth;

class DetalleClasificacionEmpleado extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.DetalleClasificacionEmpleado';
    protected $primaryKey = 'idDetalle';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	
	public static function actualizarClasificacion($info,$idEmpleado){
		$count = DetalleClasificacionEmpleado::where("idEmpleado","=",$idEmpleado)->count();
		if($count > 0) DetalleClasificacionEmpleado::where("idEmpleado","=",$idEmpleado)->delete();
		if(count($info)){
			foreach ($info as $ce) {
	            $detalleClasificacion = new DetalleClasificacionEmpleado;
	            $detalleClasificacion->idEmpleado = $idEmpleado;
	            $detalleClasificacion->idClasificacionApoyo = $ce;
	            $detalleClasificacion->fechaCreacion = Carbon::now();
	            $detalleClasificacion->idUsuarioCreacion = Auth::User()->idUsuario;
	            $detalleClasificacion->save();
        	}
		}
		
	}

	public static function getDetalleClasificacion($idEmpleado){
		$tablaEmpleados = 'dnm_rrhh_si.RH.empleados';
		return DetalleClasificacionEmpleado::join('dnm_rrhh_si.RH.empleados','dnm_rrhh_si.RH.empleados.idEmpleado','dnm_rrhh_si.RH.DetalleClasificacionEmpleado.idEmpleado')
											->select('dnm_rrhh_si.RH.DetalleClasificacionEmpleado.idClasificacionApoyo')
											->where('dnm_rrhh_si.RH.DetalleClasificacionEmpleado.idEmpleado','=',$idEmpleado)
											->pluck('idClasificacionApoyo');
	}

}
