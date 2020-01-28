<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class Jefes extends Model {

	protected $table = 'dnm_rrhh_si.RH.jefes';
    protected $primaryKey = 'idJefe';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';

	public static function isThisPlazaABoss($idPlazaFuncional){
		if(Jefes::where('idPlazaFuncional',$idPlazaFuncional)->count()>0){
			return true;
		}else{
			return false;
		}
	}
}