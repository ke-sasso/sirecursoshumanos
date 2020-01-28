<?php namespace App\Models\rrhh\rh;

use Illuminate\Database\Eloquent\Model;
use DB;

class ContactosEmpleados extends Model {

	protected $table = 'dnm_rrhh_si.RH.contactosEmpleados';
    protected $primaryKey = 'id';
	 public $timestamps = false;
	protected $connection = 'sqlsrv';


	public static function getContactos($dui){
     return DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.contactosEmpleados as cont')
              ->join('dnm_rrhh_si.RH.parentescos as paren','cont.parentesco','=','paren.idParentesco')
                ->where('cont.duiEmpleado',$dui)
		      ->select('cont.id','cont.nombre','paren.nombreParentesco','cont.celular','cont.telefonoFijo','cont.direccion')
		      ->get();
		    

		


	}


}
