<?php namespace App\Models\rrhh;
 
 use Illuminate\Database\Eloquent\Model;
 
 class CatDependientes extends Model {
 

 	protected $table = 'dnm_rrhh_si.RH.dependientes';
     protected $primaryKey = 'idDependiente';
 	 public $timestamps = false;
 	protected $connection = 'sqlsrv';
 	
 }