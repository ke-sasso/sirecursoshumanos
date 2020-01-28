<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TiposConocimientos extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.tiposConocimientos';
    protected $primaryKey = 'idTipoConocimiento';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function findTipoConocimientoSelectize($query){

        return TiposConocimientos::where('nombreTipoConocimiento','LIKE','%'.$query.'%')
                ->select('nombreTipoConocimiento','idTipoConocimiento')->distinct('nombresTipoConocimiento')
                ->take(100)->get();
    }
}