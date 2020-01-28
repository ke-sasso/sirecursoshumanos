<?php namespace App\Http\Controllers;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\SeguroRequest;
use Session;
use Redirect;
use Yajra\Datatables\Datatables;
use File;
use Crypt;
use Carbon\Carbon;
use Response;
use DateTime;
use App\Unidades;
use App\CatEmpleados;
use App\CatPlazasFuncionales;
use App\PlazasNominales;
use App\Models\rrhh\MarcasEmpleado;
use App\Models\rrhh\VwAllPermisos;
use App\Models\rrhh\rh\Municipios;
use App\Models\rrhh\rh\TiposContratos;
class RecursosHumanosController extends Controller {

	public function __construct(){
        $this->middleware('auth');
    }
  	public function index()
	{
		$unidades = Unidades::all();
		$plazas = CatPlazasFuncionales::all();
		$nominales = PlazasNominales::all();
		$tipo = TiposContratos::all();
		$data = ['title' 		=> 'Recursos Humanos - Expediente Personal Laboral'
				,'subtitle'		=> ''
				,'unidades'		=> $unidades
				,'plazas' 		=> $plazas
				,'nominales'	=> $nominales
				,'tipo'			=> $tipo];

		return view('urh.expedienteEmpleados',$data);
	}

 public function   rowEmpleados(Request $request){

       $empleados =  CatEmpleados::getEmpleados();

		return Datatables::of($empleados)

			   ->addColumn('detalle', function ($dt) {

				    return	'<a href="'.route('ver.expediente.empleado',['idEmpleado' =>Crypt::encrypt($dt->idEmpleado)]).'" class="btn btn-xs btn-success btn-perspective" >CONSULTAR</a>';

					})
			 ->filter(function($query) use ($request){
			 	          if($request->has('codigo')){

	        					$query->where('emple.idEmpleado','=',$request->get('codigo'));
	        				}

	        			if($request->has('unidad')){

	        					$query->where('uni.idUnidad','=',$request->get('unidad'));
	        				}
	        				if($request->has('plaza')){

	        					$query->where('plaza.idPlazaFuncional','=',$request->get('plaza'));
	        				}
	        				if($request->has('tipo')){

	        					$query->where('emple.contratoId','=',$request->get('tipo'));
	        				}
	        				if($request->has('nominal')){

	        					$query->where('emple.idPlazaNominal','=',$request->get('nominal'));
	        				}
	        				if($request->has('estado')){

	        					$query->where('emple.estadoId','=',$request->get('estado'));
	        				}
	        			if($request->has('dui')){

	        					$query->where('emple.dui','=',$request->get('dui'));
	        				}
                        if($request->has('codigo')){

	        					$query->where('emple.idEmpleado','=',$request->get('codigo'));
	        				}
                          if($request->has('nombre')){

	        					$query->where('emple.nombresEmpleado','like',"%".mb_strtoupper((string)$request->get('nombre'))."%");

	        				}
                        if($request->has('apellido')){

	        					$query->where('emple.apellidosEmpleado','like',"%".mb_strtoupper((string)$request->get('apellido'))."%");

	        				}
                        if($request->has('nombre') && $request->has('apellido')){
                              //   ->where('nombre_comercial','like',"%".(string)$request->get('nombre_comercial')."%")
	        					$query->where('emple.apellidosEmpleado','like',"%".mb_strtoupper((string)$request->get('apellido'))."%")
	        					->where('emple.nombresEmpleado','like',"%".mb_strtoupper((string)$request->get('nombre'))."%");

	        				}


	        			})

			->make(true);

	}



}