<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

use DB;

class InformacionEstudio extends Model {

	protected $table = 'dnm_rrhh_si.RH.infoEstudios';
	protected $primaryKey = 'id';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';



	public static function getList($dui)
	{
		return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.infoEstudios')
		    ->leftJoin('dnm_rrhh_si.RH.institucionesEstudios','idInstitucion','=','institucionIdestudio')
			->leftJoin('dnm_rrhh_si.RH.paisesEstudios','idPais','=','paisIdinstitucion')
			->join('dnm_rrhh_si.RH.tiposEstudios','idTipo','=','tipoEstudio')
			->where('duiEmpleado',$dui)
			->select(DB::raw('id,lugar,titulo,CONCAT(nombreInstitucion,\' (\',nombrePais,\')\') as institucion,nombreTipo, 
			 annio as annio_mostrar,copiaTitulo,copiaCredencialesprofesion,urlDocumento'))
			->orderBy('annio_mostrar','desc')->get();
	}

}
