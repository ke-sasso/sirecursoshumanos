<?php namespace App\Http\Controllers;

use App;
use Session;
use App\Models\establecimientos;
use App\Models\dnm_sesiones_si\ses\sesiones;
use App\Models\dnm_sesiones_si\ses\sesion_detalle;
use App\Models\dnm_establecimientos_si\est\solicitudes_establecimientos;
use App\UserOptions;
use Illuminate\Http\Request;
use DB;
use Datatables;
use Auth;
use Debugbar;
class InicioController extends Controller {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		
	}
	/**
	 * Muestra el Inicio de la aplicacion (Dashboard).
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = ['title' 			=> 'SISTEMA DE RECURSOS HUMANOS' 
				,'subtitle'			=> ''
				,'breadcrumb' 		=> [
			 ['nom'	=>	'', 'url' => '#']
				]];
		
		$jefe = (UserOptions::where('codOpcion',458)->where('codUsuario',Auth::user()->idUsuario)->where('idPerfil',26)->count());
		$data['jefatura'] = (empty($jefe)) ? 0 : $jefe ;
		
		return view('inicio.index',$data);

	}

	/**
	 * Cambia configuración para ocultar menú lateral.
	 *
	 * @return void
	 */
	public function cfgHideMenu()
	{
		$cfgHideMenu = Session::get('cfgHideMenu',false);
		$cfgHideMenu = ($cfgHideMenu)?false:true;
		Session::put('cfgHideMenu',$cfgHideMenu);
	}
	
}