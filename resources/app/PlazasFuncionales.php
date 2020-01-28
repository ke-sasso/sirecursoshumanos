<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\rrhh\rh\Jefes;
use DB;


class PlazasFuncionales extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.plazasFuncionales';
    protected $primaryKey = 'idPlazaFuncional';
	public $timestamps = false;
	protected $connection = 'sqlsrv';

	public  function jefes(){
    	return $this->hasMany('App\CatJefes','idPlazaFuncional','idPlazaFuncional');
    }

	public function unidad(){
		return $this->hasOne('App\Unidades','idUnidad','idUnidad');
	}
	public function plazaPadre(){
		return $this->hasOne('App\PlazasFuncionales','idPlazaFuncional','idPlazaFuncional');
	}
	public function plazanominal(){
		return $this->hasOne('App\PlazasNominales','idPlazaNominal','idPlazaNominal');
	}

	public function esJefatura(){
		return Jefes::isThisPlazaABoss($this->idPlazaFuncional);
	}

	public  function conocimientos(){
    	return $this->hasMany('App\Models\rrhh\rh\ConocimientosPlazaFun','idPlazaFuncional','idPlazaFuncional');
    }
    public  function dataconocimientos(){
    	return $this->hasMany('App\Models\rrhh\rh\ConocimientosPlazaFun','idPlazaFuncional','idPlazaFuncional');
    }

	public static function getPlazas(){
			return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.plazasFuncionales as PF1')
		        	->leftjoin('dnm_rrhh_si.RH.plazasFuncionales as PF2', 'PF1.idPlazaFuncionalPadre', '=' ,'PF2.idPlazaFuncional')
					->leftjoin('dnm_rrhh_si.RH.unidades as uni', 'uni.idUnidad', '=' ,'PF1.idUnidad')
					->leftjoin('dnm_rrhh_si.RH.plazasNominales as nom', 'nom.idPlazaNominal', '=' ,'PF1.idPlazaNominal')
					->select('PF1.idPlazaFuncional','PF1.nombrePlaza','PF2.nombrePlaza as plazaPadre', 'nom.nombrePlazaNominal', 'uni.nombreUnidad','PF1.descripcionPlaza','PF1.fechaInicial','PF1.mision');
					//->get();
         /* $query = "select PF1.idPlazaFuncional,PF1.nombrePlaza,PF2.nombrePlaza as plazaPadre, nom.nombrePlazaNominal, uni.nombreUnidad,PF1.descripcionPlaza,PF1.fechaInicial
       from dnm_rrhh_si.RH.plazasFuncionales as PF1
  LEFT JOIN dnm_rrhh_si.RH.plazasFuncionales as PF2 on PF1.idPlazaFuncionalPadre = PF2.idPlazaFuncional
  LEFT JOIN dnm_rrhh_si.RH.unidades as uni ON uni.idUnidad = PF2.idUnidad
  LEFT JOIN dnm_rrhh_si.RH.plazasNominales as nom ON nom.idPlazaNominal = PF2.idPlazaNominal";*/
          return DB::select($query);

	}
    public function funciones()
	{
		return $this->hasMany('App\Models\rrhh\rh\Funciones','idPlazaFuncional','idPlazaFuncional');
	}

	public static function findPlazaFunSelectize($query){

        return PlazasFuncionales::where('nombrePlaza','LIKE','%'.$query.'%')
                ->select('nombrePlaza','idPlazaFuncional')->distinct('nombrePlaza')
                ->take(10)->get();
    }
}


