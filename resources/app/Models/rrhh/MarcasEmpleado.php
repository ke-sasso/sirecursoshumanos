<?php namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class MarcasEmpleado extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.marcacion';
    protected $primaryKey = 'CodEmpleado';
	protected $timestap = false;
	protected $connection = 'sqlsrv';


	public static function getHistMarcacion($idEmpleado = null,$fechaInicio,$fechaFinal)
	{
		$fDesde = date('Ymd',strtotime($fechaInicio));
		$fHasta = date('Ymd',strtotime($fechaFinal.' +1 day'));

		$marcacionesEmp = MarcasEmpleado::where('CodEmpleado','=',Auth::user()->idEmpleado)
									->whereBetween('FechaMarca',array($fDesde,$fHasta))
									->orderBy('FechaMarca','DESC')
									->get();
		
		return $marcacionesEmp;
	}

	public static function getHistMarcacionEmpleado($idEmpleado)
	{

		$marcacionesEmp = MarcasEmpleado::where('CodEmpleado','=',$idEmpleado)
									->orderBy('FechaMarca','DESC')
									->get()->toArray();
		return $marcacionesEmp;
	}
}
