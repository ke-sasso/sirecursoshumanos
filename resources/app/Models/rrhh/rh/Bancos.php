<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model {

	//
	protected $table = 'dnm_rrhh_si.PLA.catBancos';
    protected $primaryKey = 'idBanco';
	public $timestamps = false;
	protected $connection = 'sqlsrv';

	public static function getList()
	{
		return Bancos::pluck('nombreBanco','idBanco');
	}


}
