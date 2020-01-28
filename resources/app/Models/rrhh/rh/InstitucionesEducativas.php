<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class InstitucionesEducativas extends Model {

	protected $table = 'dnm_rrhh_si.RH.institucionesEstudios';
	protected $primaryKey = 'idInstitucion';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

 public static function getInstituciones()
	{
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.institucionesEstudios')
			->join('dnm_rrhh_si.RH.paisesEstudios','idPais','=','paisIdinstitucion')
			->select('nombrePais','nombreInstitucion','idInstitucion','estadoIntitucion')->get();
	}

	 public static function getPaisInstituciones()
	{
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.paisesEstudios')
			->where('estadoPais',1)
			->select('nombrePais','idPais')->get();
	}
	public static function buscarInstitucion($query){
         return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.institucionesEstudios')
            ->where('nombreInstitucion','LIKE','%'.$query.'%') 
            ->join('dnm_rrhh_si.RH.paisesEstudios','idPais','=','paisIdinstitucion')

            ->select('idInstitucion','nombreInstitucion','nombrePais')->take(10)->get();       
    }


}