<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;
use Auth;
use Crypt;

use App\Unidades;
use App\PlazasFuncionales;
use App\PlazasNominales;

use App\Models\rrhh\rh\Empleados;
use App\Models\rrhh\rh\Funciones;
use App\Models\rrhh\rh\Tareas;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Datatables;

class PerfilesController extends Controller {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
	}

	

	public function showPerfilesPuesto(){	
		$data = ['title' 			=> 'Perfiles de Plaza' 
				,'subtitle'			=> 'Administrador RH'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Perfiles Plaza', 'url' => '#']
				]]; 
		
		$data['unidades']=Unidades::all();
		$data['plazasfun']=PlazasFuncionales::all();
		$data['plazasnom']=PlazasNominales::all();

		return view('perfiles.listar',$data);
	}

	public function getDataRowsPerfilesP(Request $request){
		
		$drs = DB::connection('sqlsrv')->table('dnm_rrhh_si.RH.vwEmpleados');
				
        return Datatables::of($drs)
        	->addColumn('mostrar', function ($dt) {
            	return '<a href="'.route('perfiles.puesto.emp',['idEmp' => Crypt::encrypt($dt->idEmpleado)]).'" class="btn btn-xs btn-info btn-perspective"><i class="fa fa-eye"></i> Mostrar</a>';
            })

        	->filter(function($query) use ($request){
							
	        				if($request->has('empleado')){
	        					$query->where('empleado','like','%'.mb_strtoupper($request->get('empleado'),'UTF-8').'%');
	        				}

	        				if($request->has('unidad')){ 	
	        					$query->where('idUnidad','=',$request->get('unidad'));
	        				}
	        				if($request->has('pfun')){
	        					$query->where('idPlazaFuncional','=',(int)$request->get('pfun'));
	        				}
	        				if($request->has('pnom')){
	        					$query->where('idPlazaNominal','=',(int)$request->get('pnom'));
	        				}


	        			})
            ->make(true);
	}

	public function showEmpPerfilPuesto($idEmp){
		try{
			$idEmpleado = Crypt::decrypt($idEmp);
			$data = ['title' 			=> 'Perfiles de Plaza' 
					,'subtitle'			=> 'Administrador RH'
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Perfiles de Plaza', 'url' => route('perfiles.puesto')],
				 		['nom'	=>	'Mostrar', 'url' => '#']
					]]; 
			$data['emp'] = Empleados::findOrFail($idEmpleado);

			return view('perfiles.personal',$data);
		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}
	}

	public function mostrarTarea(Request $request,$idEmp,$idTar){
		try{
			$idTarea = Crypt::decrypt($idTar);
			$idEmpleado = Crypt::decrypt($idEmp);

			$tar = Tareas::findOrFail($idTarea);

			$data = ['title' 			=> 'Perfiles de Plaza' 
					,'subtitle'			=> 'Administrador RH'
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Perfiles de Plaza', 'url' => route('perfiles.puesto')],
				 		['nom'	=>	'Mostrar', 'url' => route('perfiles.puesto.emp',['idEmp' => $idEmp])]
					]]; 
			
			$data['emp'] = Empleados::findOrFail($idEmpleado);
			$data['reTar'] = $tar;
			
			return view('perfiles.tarea',$data);
		}catch(ModelNotFoundException $mnfe){
			return view('errors.generic',['error' => 'Algo salio mal, parece que no se ha podido encontrar algunos datos!']);
		}catch(DecryptException $de){
			return view('errors.generic',['error' => 'Algo salio mal, parece que los datos proporcionados no son validos!']);
		}
	}
}
