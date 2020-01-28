<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CatPlazasFuncionales extends Model {

    protected $table = 'dnm_rrhh_si.RH.plazasFuncionales';
    protected $primaryKey = 'idPlazaFuncional';
	protected $timestap = false;
	protected $connection = 'sqlsrv';

}
