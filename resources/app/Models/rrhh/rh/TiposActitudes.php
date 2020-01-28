<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class TiposActitudes extends Model {

	//
	protected $table = 'dnm_rrhh_si.RH.tiposActitudes';
    protected $primaryKey = 'idTipoActitud';
	public $timestamps = false;
	protected $connection = 'sqlsrv';
	const CREATED_AT = 'fechaCreacion';
	const UPDATED_AT = 'fechaModificacion';

	public static function findTipoActitudSelectize($query){

        return TiposActitudes::where('nombreTipoActitud','LIKE','%'.$query.'%')
        		->where('activo',1)
                ->select('nombreTipoActitud','idTipoActitud')->distinct('nombresTipoActitud')
                ->take(10)->get();
    }

}