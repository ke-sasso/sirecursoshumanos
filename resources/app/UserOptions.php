<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class UserOptions extends Model {
	
	protected $table = 'dnm_catalogos.sys_usuario_roles';
	protected $primaryKey = ['codUsuario','codOpcion'];
	protected $timestap = false;

	public static function vrfOpt($id_opcion){		
		if (UserOptions::where('codUsuario',Auth::user()->idUsuario)->whereIn('codOpcion',[0,$id_opcion])->count() > 0)
			return true;
		else
			return false;
	}

	public static function verifyOption($id_usuario,$id_opcion){
		if (UserOptions::where('codUsuario',$id_usuario)->where('codOpcion',0)->count() > 0)
			return true;
		elseif (UserOptions::where('codUsuario',$id_usuario)->where('codOpcion',$id_opcion)->count() > 0) {
			return true;
		}
		else
			return false;
	}

	public static function getAutUserOptions(){
				return UserOptions::join('dnm_catalogos.sys_opciones','codOpcion','=','idOpcion')
		->where('idAplicacion',9)->where('codUsuario',Auth::user()->idUsuario)->select('codOpcion')->get();
		/*$opciones = UserOptions::join('dnm_catalogos.sys_opciones','codOpcion','=','idOpcion')
		->where('codUsuario',Auth::user()->idUsuario)->select('codOpcion')->lists('codOpcion');
		$return = array();
		foreach ($opciones as $key => $value) {
			dd($value->codOpcion);
		}
		return $return;*/
	}



}
