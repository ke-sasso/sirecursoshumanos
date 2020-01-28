<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PlazasNominales extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.plazasNominales';
    protected $primaryKey = 'idPlazaNominal';
	public $timestamps = false;
	protected $connection = 'sqlsrv';

	public static function findPlazaNomSelectize($query){

        return PlazasNominales::where('nombrePlazaNominal','LIKE','%'.$query.'%')
                ->select('nombrePlazaNominal','idPlazaNominal')->distinct('nombrePlazaNominal')
                ->take(10)->get();
    }

}
