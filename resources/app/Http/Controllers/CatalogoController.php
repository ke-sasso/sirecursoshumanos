<?php namespace App\Http\Controllers;
use App\CatJefes;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Redirect;
use Yajra\Datatables\Datatables;
use File;
use Crypt;
use Carbon\Carbon;
use Response;
use DateTime;
use App\Unidades;
use App\EstadoLaboral;
use App\ClasificacionEmpleado;
use App\UserOptions;
use App\User;
use App\CatEmpleados;
use App\Models\rrhh\rh\TipoEstudio;
use App\Models\rrhh\rh\InstitucionesEducativas;
use App\Models\rrhh\rh\Parentesco;
use App\Models\rrhh\rh\GrupoSanguineo;
use App\Models\rrhh\rh\Bancos;
use App\Models\rrhh\rh\TiposActitudes;
use App\Models\rrhh\rh\Empleados;
use App\Models\rrhh\rh\ConocimientosPlazaFun;
use App\CatMotivos;
use App\PlazasFuncionales;
use App\PlazasNominales;
use App\Models\rrhh\edc\Evaluaciones;


class CatalogoController extends Controller {

	public function __construct(){
        $this->middleware('auth');
    }

    /*************************************CATALOGO UNIDADES**************************************************/

	    public function indexUnidad(){

	    $data = ['title' 			=> 'Cat&aacute;logo de unidades'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Unidades', 'url' => route('unidad.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.unidad.index',$data);
		}

		public function  getDataRowsUnidad(Request $request){
			$unidades=Unidades::all();
			return Datatables::of($unidades)
				   ->addColumn('detalle', function ($dt) {

		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idUnidad.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}

	    public function nuevaUnidad(){
	    $data = ['title' 			=> 'Nueva unidad'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Unidades', 'url' => route('unidad.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.unidad.nuevo',$data);
		}

		public function storeUnidad(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:500',
	        	'prefijo'=>'max:45',
	        	'costos'=>'max:10',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre de la unidad',
				'prefijo' => 'prefijo de la unidad',
				'costo' => 'costos de la unidad',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$unidad = new Unidades;
		    	$unidad->nombreUnidad = $request->nombre;
		    	$unidad->prefijo = $request->prefijo;
		    	$unidad->centroCostos =  $request->costos;
		    	$unidad->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
		public function getUnidad(Request $request){
		    $idUnidad = $request->param;
		    $unidad = Unidades::find($idUnidad);
		    return response()->json($unidad);
		}
	    public function editarUnidad(Request $request){
	   $v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:500',
	        	'prefijo'=>'max:45',
	        	'costos'=>'max:10',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre de la unidad',
				'prefijo' => 'prefijo de la unidad',
				'costo' => 'costos de la unidad',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$unidad = Unidades::find($request->id);
		    	$unidad->nombreUnidad = $request->nombre;
		    	$unidad->prefijo = $request->prefijo;
		    	$unidad->centroCostos =  $request->costos;
		    	$unidad->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

	 /*************************************CATALOGO TIPO DE ESTUDIO**************************************************/
	 public function indexTipoEst(){

	    $data = ['title' 			=> 'Cat&aacute;logo de tipos de estudio'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Tipos de estudio', 'url' => route('tipoEst.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.tipoEstudio.index',$data);
		}

		public function  getDataRowsTipoEst(Request $request){
			$tipoEstudio=TipoEstudio::all();
			return Datatables::of($tipoEstudio)
				   ->addColumn('detalle', function ($dt) {

		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idTipo.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}

	public function nuevoTipoEst(){
	    $data = ['title' 			=> 'Nuevo tipo de estudio'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Tipos de estudio', 'url' => route('tipoEst.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => '']

					]];
		return view('catalogos.tipoEstudio.nuevo',$data);
		}
		public function storeTipoEst(Request $request){

			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:255',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre tipo de estudio',

		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$tipoEst = new TipoEstudio;
		    	$tipoEst->idTipo = $tipoEst::getNextID();
		    	$tipoEst->nombreTipo = $request->nombre;
		    	$tipoEst->usuCreacion = Auth::User()->idUsuario;
		    	$tipoEst->fechaCreacion = Carbon::now();
		    	$tipoEst->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
	    public function getTipoEst(Request $request){
		    $idTipo = $request->param;
		    $tipoEst = TipoEstudio::find($idTipo);
		    return response()->json($tipoEst);
		}
		public function editarTipoEst(Request $request){
	   $v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:255',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre tipo de estudio',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$tipoEst = TipoEstudio::find($request->id);
		    	$tipoEst->nombreTipo = $request->nombre;
		    	$tipoEst->usuModificacion = Auth::User()->idUsuario;
		    	$tipoEst->fechaModificacion = Carbon::now();
		    	$tipoEst->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

	 /*************************************CATALOGO INSTITUCIONES ESTUDIOS**************************************************/
	 public function indexInstitucion(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Instituciones educativas'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Instituciones Educativas', 'url' => route('institucion.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.instituciones.index',$data);
		}

		public function  getDataRowsInstitucion(Request $request){
			$instituciones=InstitucionesEducativas::getInstituciones();
			return Datatables::of($instituciones)
				   ->addColumn('detalle', function ($dt) {

		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idInstitucion.'\');" ><i class="fa fa-pencil"></i></a>';

						})
			 ->addColumn('estado', function ($dt) {

						if($dt->estadoIntitucion == 1)
							return '<span class="label label-success">ACTIVO </span>';
						else
							return '<span class="label label-warning">INACTIVO</span>';

						})

			->make(true);
		}

	public function nuevaInstitucion(){
	    $data = ['title' 			=> 'Nueva Instituci&oacute;n'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Instituciones Educativas', 'url' => route('institucion.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];

	    $data['pais'] = InstitucionesEducativas::getPaisInstituciones();
		return view('catalogos.instituciones.nuevo',$data);
		}
		public function storeInstitucion(Request $request){


			$v = Validator::make($request->all(),[
	        	'nombreInstitucion'=>'required|max:150',
	        	'idPais'=>'required'
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreInstitucion' => 'nombre de institución',
	   		    'idPais' => 'país',

		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$institucion = new InstitucionesEducativas;
		    	$institucion->nombreInstitucion = $request->nombreInstitucion;
		    	$institucion->paisIdinstitucion = $request->idPais;
		    	$institucion->estadoIntitucion = $request->estado;
		    	$institucion->usuarioCreacion = Auth::User()->idUsuario;
		    	$institucion->fechaCreacion = Carbon::now();
		    	$institucion->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		   public function getInstitucion(Request $request){
		    $id = $request->param;
		    $tipoEst = InstitucionesEducativas::find($id);
		    return response()->json($tipoEst);
		}

     public function getPaises(){

	    $paises = InstitucionesEducativas::getPaisInstituciones();
		 return response()->json($paises);
		}

		public function editarInstitucion(Request $request){
	   $v = Validator::make($request->all(),[
	        	'nombreInstitucion'=>'required|max:150',
	        	'idPais'=>'required'
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreInstitucion' => 'nombre de institución',
	   		    'idPais' => 'país',

		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$institucion =  InstitucionesEducativas::find($request->id);
		    	$institucion->nombreInstitucion = $request->nombreInstitucion;
		    	$institucion->paisIdinstitucion = $request->idPais;
		    	$institucion->estadoIntitucion = $request->estado;
		    	$institucion->usuarioModificacion = Auth::User()->idUsuario;
		    	$institucion->fechaModificacion = Carbon::now();
		    	$institucion->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

 /*************************************CATALOGO PARENTESCO**************************************************/
	 public function indexParentesco(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Parentesco'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Parentesco', 'url' => route('parentesco.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.parentesco.index',$data);
		}
		public function  getDataRowsParentesco(Request $request){
			$parentesco=Parentesco::all();
			return Datatables::of($parentesco)
				   ->addColumn('detalle', function ($dt) {

		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idParentesco.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}
       public function nuevoParentesco(){
	    $data = ['title' 			=> 'Nuevo Parentesco'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Parentesco', 'url' => route('parentesco.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.parentesco.nuevo',$data);
		}

	public function storeParentesco(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombreParentesco'=>'required|max:200',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreParentesco' => 'nombre parentesco',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$parentescos = new Parentesco;
		    	$parentescos->idParentesco = $parentescos->getNextID();
		    	$parentescos->nombreParentesco = $request->nombreParentesco;
                $parentescos->usuCreacion = Auth::User()->idUsuario;
                $parentescos->fechacreacion = Carbon::now();
		    	$parentescos->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		 public function getParentesco(Request $request){
		    $id = $request->param;
		    $parentesco = Parentesco::find($id);
		    return response()->json($parentesco);
		}

			public function editarParentesco(Request $request){
	     	$v = Validator::make($request->all(),[
	        	'nombreParentesco'=>'required|max:200',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreParentesco' => 'nombre parentesco',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$parentescos = Parentesco::find($request->id);
		    	$parentescos->nombreParentesco = $request->nombreParentesco;
                $parentescos->usuModificacion =Auth::User()->idUsuario;
                $parentescos->fechaModificacion = Carbon::now();
		    	$parentescos->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}


 /*************************************CATALOGO GRUPO SANGUINEO**************************************************/

			 public function indexGrupoSang(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Grupo Sanguineo'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Grupo Sanguineo', 'url' => route('grupoSang.listar')],
				 	    ['nom'	=>	'', 'url' => ''],


					]];
			return view('catalogos.grupoSanguineo.index',$data);
		}

		public function  getDataRowsGrupoSang(Request $request){
			$grupo=GrupoSanguineo::all();
			return Datatables::of($grupo)
				   ->addColumn('detalle', function ($dt) {

		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idGrupo.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}
		public function nuevoGrupoSang(){
	    $data = ['title' 			=> 'Nuevo grupo sanguineo'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Grupo Sanguineo', 'url' => route('grupoSang.listar')],
				 	    ['nom'	=>	'Nuevo registro', 'url' => ''],


					]];
		return view('catalogos.grupoSanguineo.nuevo',$data);
		}

	public function storeGrupoSang(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombreGrupo'=>'required|max:45',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreGrupo' => 'nombre grupo sanguineo',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$grupo = new GrupoSanguineo;
		    	$grupo->nombreGrupo = $request->nombreGrupo;
                $grupo->usuCreacion =Auth::User()->idUsuario;
                $grupo->fechaCreacion = Carbon::now();
		    	$grupo->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}


		 public function getGrupoSang(Request $request){
		    $id = $request->param;
		    $grupo = GrupoSanguineo::find($id);
		    return response()->json($grupo);
		}

			public function editarGrupoSang(Request $request){
	  	$v = Validator::make($request->all(),[
	        	'nombreGrupo'=>'required|max:45',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreGrupo' => 'nombre grupo sanguineo',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$grupo =  GrupoSanguineo::find($request->id);
		    	$grupo->nombreGrupo = $request->nombreGrupo;
                $grupo->usuModificacion =Auth::User()->idUsuario;
                $grupo->fechaModificacion = Carbon::now();
		    	$grupo->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

 /*************************************CATALOGO MOTIVOS**************************************************/
	 public function indexMotivos(){

	    $data = ['title' 			=> 'Cat&aacute;logo  Motivos de permisos'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Motivos de permisos', 'url' => route('motivos.listar')],
				 		['nom'	=>	'', 'url' =>''],

					]];
			return view('catalogos.motivos.index',$data);
		}

		public function  getDataRowsMotivo(Request $request){
			$motivos=CatMotivos::all();
			return Datatables::of($motivos)

				   	->addColumn('estado',function($dt){
						if($dt->estado == 'A')
							return '<span class="label label-success">ACTIVO </span>';
						else if($dt->estado== 'I')
							return '<span class="label label-warning">INACTIVO</span>';

					})

				   ->addColumn('detalle', function ($dt) {
				   	return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idMotivo.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}
				public function nuevoMotivo(){
	    $data = ['title' 			=> 'Nuevo motivo'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Motivos de permisos', 'url' => route('motivos.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' =>''],

					]];
		return view('catalogos.motivos.nuevo',$data);
		}

	public function storeMotivo(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:100',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'motivo',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$motivo = new CatMotivos;
		    	$motivo->nombre = $request->nombre;
		    	$motivo->estado = $request->estado;
                $motivo->idUsuarioCrea =Auth::User()->idUsuario;
                $motivo->fechaCreacion = Carbon::now();
		    	$motivo->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		 public function getMotivo(Request $request){
		    $id = $request->param;
		    $motivo = CatMotivos::find($id);
		    return response()->json($motivo);
		}

			public function editarMotivo(Request $request){
	  		$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:100',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'motivo',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$motivo =  CatMotivos::find($request->id);
		    	$motivo->nombre = $request->nombre;
		    	$motivo->estado = $request->estado;
                $motivo->idUsuarioModifica =Auth::User()->idUsuario;
                $motivo->fechaModificacion = Carbon::now();
		    	$motivo->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

/*************************************CATALOGO PLAZA FUNCIONALES**************************************************/
 public function indexPlazaFunc(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Plazas Funcionales'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Plazas funcionales', 'url' => route('plazaFunc.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];

		$unidades = Unidades::all();
		/**
			Se evalua si el usuario posee un perfil de jefe de unidad, esto con el objetivo de filtrar las plazas funcionales
			por la unidad a la que pertenece
		**/
		$data['unidadJefatura'] = '';
		if( (UserOptions::where('codOpcion',458)->where('codUsuario',Auth::user()->idUsuario)->where('idPerfil',26)->count()) > 0)
		{
			$idEmpleado = User::where('idUsuario',Auth::user()->idUsuario)->select('idEmpleado')->first();

			$empleado = CatEmpleados::getEmpleadosUnidad($idEmpleado->idEmpleado);

			$data['unidadJefatura'] = $empleado[0]->idUnidad;

		}

		$data['unidades'] = $unidades;
			return view('catalogos.plazasFuncionales.index',$data);
		}

		public function  getDataRowsPlazaFunc(Request $request){
			$plazaFun=PlazasFuncionales::getPlazas();
			return Datatables::of($plazaFun)
		    ->addColumn('detalle', function ($dt) {
		   		return	'
		   		<a data-toggle="tooltip" data-placement="top" title="Editar plaza" class="btn btn-xs btn-success btn-perspective" href="'.route('plazaFunc.editar',['idPlaza'=>Crypt::encrypt($dt->idPlazaFuncional)]).'"><i class="fa fa-pencil">&nbsp</i></a>
		   		<a data-toggle="tooltip" data-placement="top"  href="'.route('plazaFunc.detalle',['idPlaza'=>Crypt::encrypt($dt->idPlazaFuncional)]).'" class="btn btn-xs btn-success btn-perspective" title="Detalle"><i class="fa fa-folder-open"></i></a> ';

				})
		    ->addColumn('perfil', function ($dt) {
		   		return	'
		   		<a data-toggle="tooltip" target="_blank" data-placement="top" title="Estandares de competencia" class="btn btn-xs btn-success btn-perspective" href="'.route('generar.pdf.plaza',['text'=>'14','idPlazaFuncional'=>Crypt::encrypt($dt->idPlazaFuncional)]).'" ><i class="fa fa-file-o"></i></a> <a data-toggle="tooltip" data-placement="top" title="Matriz DACUM" class="btn btn-xs btn-success btn-perspective" target="_blank" href="'.route('generar.excel.plaza.matriz',['idPlazaFuncional'=>Crypt::encrypt($dt->idPlazaFuncional)]).'" ><i class="fa  fa-table"></i></a>';

				})
			->filter(function($query) use ($request){

				if($request->has('plazaFuncional')){
	        		$query->where('PF1.idPlazaFuncional','=',$request->get('plazaFuncional'));
				}
				if($request->has('plazaNominal')){
					$query->where('nom.idPlazaNominal','=',$request->get('plazaNominal'));
				}
				if($request->has('unidad')){
					$query->where('PF1.idUnidad','=',$request->get('unidad'));
				}
				if($request->has('plazaEmpleado')){
					$query->where('PF1.idPlazaFuncional','=',$request->get('plazaEmpleado'));
				}
				if($request->has('plazaPadre')){
					$query->where('PF2.idPlazaFuncional','=',$request->get('plazaPadre'));
				}
			})
			->make(true);
			//<a data-toggle="tooltip" data-placement="top" title="Matriz" class="btn btn-xs btn-success btn-perspective" href="'.route('generar.pdf.plaza.matriz',['texto'=>'11','idPlazaFuncional'=>Crypt::encrypt($dt->idPlazaFuncional)]).'" ><i class="fa  fa-table"></i></a>
		}

	public function findEmpleadoSelectize(Request $request){
		$query = e($request->q);

		if(!$query && $query == '') return response()->json(array(), 400);

		$data = Empleados::findEmpleadoSelectize($query);

		return response()->json(array(
			'data'=>$data
		));
	}

	public function findPlazaFunSelectize(Request $request){
		$query = e($request->q);

		if(!$query && $query == '') return response()->json(array(), 400);

		$data = PlazasFuncionales::findPlazaFunSelectize($query);

		return response()->json(array(
			'data'=>$data
		));
	}

	public function findPlazaNomSelectize(Request $request){
		$query = e($request->q);

		if(!$query && $query == '') return response()->json(array(), 400);

		$data = PlazasNominales::findPlazaNomSelectize($query);

		return response()->json(array(
			'data'=>$data
		));
	}

	public function nuevaPlazaFunc(){
	    $data = ['title' 			=> 'Nueva plaza'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Plazas funcionales', 'url' => route('plazaFunc.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		$data['unidad'] = Unidades::all();
		$data['plazaNom'] = PlazasNominales::all();
		$data['plazaFun'] = PlazasFuncionales::all();
		$data['conocimientos'] = TiposActitudes::all();

		return view('catalogos.plazasFuncionales.nuevo',$data);
		}

			public function storePlazaFunc(Request $request){

			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:250',
	        	'fecha'=>'required'
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre de la plaza',
	   		     'fecha'=>'fecha inicial'
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {

				if(strlen($request->idUnidad)>0){
					$nUnidad=$request->idUnidad;

				}else{
					$nUnidad=null;
				}
				if(strlen($request->idNominal)>0){
					$nNomi=$request->idNominal;

				}else{
					$nNomi=null;
				}
				if(strlen($request->idPadre)>0){
					$nPadre=$request->idPadre;

				}else{
					$nPadre=null;
				}
		    	$plazaFun = new PlazasFuncionales;
		    	$plazaFun->nombrePlaza = $request->nombre;
		    	$plazaFun->descripcionPlaza = $request->descripcion;
		    	$plazaFun->idUnidad = $nUnidad;
		    	$plazaFun->idPlazaNominal = $nNomi;
		    	$plazaFun->idPlazaFuncionalPadre = $nPadre;
		    	$plazaFun->fechaInicial = $request->fecha;
		    	$plazaFun->mision = $request->mision;
		    	$plazaFun->habilidades = $request->habilidades;
		    	$plazaFun->conocimientos = $request->conocimiento;
		    	$plazaFun->equipoMateriales = $request->equipo;
		    	$plazaFun->save();

		    	if(count($request->idConocimiento)>0){
		    		foreach($request->idConocimiento as $cono){
		    			$conoPlaza = new ConocimientosPlazaFun();
		    			$conoPlaza->idPlazaFuncional = $plazaFun->idPlazaFuncional;
		    			$conoPlaza->idTipoActitud = $cono;
		    			$conoPlaza->save();
		    		}
		    	}


			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		 public function getPlazaFunc(Request $request){
		    $id = $request->param;
		    $plazaFun = PlazasFuncionales::find($id);
		    return response()->json($plazaFun);
		}
		  public function getUnidades(){
	    $uni = Unidades::all();
		 return response()->json($uni);
		}
		public function getPlazasNom(){
	    $plazaNom = PlazasNominales::all();
		 return response()->json($plazaNom);
		}
		public function getPlazasListar(){
	    $plaza = PlazasFuncionales::all();
		 return response()->json($plaza);
		}

public function editarPlazaFuncIndex($idPlaza){

	    $data = ['title' 			=> 'Editar Plaza Funcional'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Plazas funcionales', 'url' => route('plazaFunc.listar')],
				 		['nom'	=>	'Editar plaza funcional registro', 'url' => ''],

					]];
		$data['unidad'] = Unidades::all();
		$data['plazaNom'] = PlazasNominales::all();
		$data['conocimientos'] = TiposActitudes::all();
		$data['plazaPadre'] = PlazasFuncionales::all();
		$data['plazaConocimientos']=ConocimientosPlazaFun::where('idPlazaFuncional',Crypt::decrypt($idPlaza))->pluck('idTipoActitud')->toArray();
		$data['plazaFun'] = PlazasFuncionales::find(Crypt::decrypt($idPlaza));
		$data['esJefe'] = CatJefes::where('idPlazaFuncional',Crypt::decrypt($idPlaza))->first();
		return view('catalogos.plazasFuncionales.editPlazaFuncional',$data);
}
public function editarPlazaFunc(Request $request){
			//dd($request->all());
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:250',
	        	'fecha'=>'required'
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre de la plaza',
	   		     'fecha'=>'fecha inicial'
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {

            if(strlen($request->idUnidad)>0){
					$nUnidad=$request->idUnidad;

				}else{
					$nUnidad=null;
				}
				if(strlen($request->idNominal)>0){
					$nNomi=$request->idNominal;

				}else{
					$nNomi=null;
				}
				if(strlen($request->idPadre)>0){
					$nPadre=$request->idPadre;

				}else{
					$nPadre=null;
				}

		    	$plazaFun = PlazasFuncionales::find($request->id);
		    	$plazaFun->nombrePlaza = $request->nombre;
		    	$plazaFun->descripcionPlaza = $request->descripcion;
		    	$plazaFun->idUnidad = $nUnidad;
		    	$plazaFun->idPlazaNominal = $nNomi;
		    	$plazaFun->idPlazaFuncionalPadre = $nPadre;
		    	$plazaFun->fechaInicial = $request->fecha;
		    	$plazaFun->mision = $request->mision;
		    	$plazaFun->habilidades = $request->habilidades;
		    	$plazaFun->conocimientos = $request->conocimiento;
		    	$plazaFun->equipoMateriales = $request->equipo;
		    	$plazaFun->save();

		    	$plazaFun->conocimientos()->delete();
		    	if(count($request->idConocimiento)>0){
		    		foreach($request->idConocimiento as $cono){
		    			$conoPlaza = new ConocimientosPlazaFun();
		    			$conoPlaza->idPlazaFuncional = $plazaFun->idPlazaFuncional;
		    			$conoPlaza->idTipoActitud = $cono;
		    			$conoPlaza->save();
		    		}
		    	}

		    	if($request->has('esJefe'))
                {
                    $jefe = new CatJefes();
                    $jefe->idPlazaFuncional = $plazaFun->idPlazaFuncional;
                    $jefe->idUsuarioCrea = Auth::user()->idUsuario;
                    $jefe->save();
                }
		    	else
                {
                    $jefe = CatJefes::where('idPlazaFuncional',$plazaFun->idPlazaFuncional)->first();
                    $jefe->delete();
                }


			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}


		/*************************************CATALOGO PLAZA NOMINALES**************************************************/
 public function indexPlazaNom(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Plazas Nominales'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Plazas nominales', 'url' => route('plazaNom.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.plazasNominales.index',$data);
		}

		public function  getDataRowsPlazaNom(Request $request){
			$plazaNom=PlazasNominales::all();
			return Datatables::of($plazaNom)
             ->addColumn('detalle', function ($dt) {
				   	return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idPlazaNominal.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}
			public function nuevaPlazaNom(){
	    $data = ['title' 			=> 'Nueva plaza nominal'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 	['nom'	=>	'Plaza nominales', 'url' => route('plazaNom.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.plazasNominales.nuevo',$data);
		}

	public function storePlazaNom(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:250',
	        	'cantidad'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre de la plaza nominal',
	   		    'cantidad' => 'cantidad de aprobadas',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$plazaNom = new PlazasNominales;
		    	$plazaNom->nombrePlazaNominal = $request->nombre;
		    	$plazaNom->descripcionPlaza = $request->descripcion;
		    	$plazaNom->cantidadAprobadas = $request->cantidad;
		    	$plazaNom->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
		public function getPlazaNom(Request $request){
		    $id = $request->param;
		    $plazaNom = PlazasNominales::find($id);
		    return response()->json($plazaNom);
		}
			public function editarPlazaNom(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:250',
	        	'cantidad'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre de la plaza nominal',
	   		    'cantidad' => 'cantidad de aprobadas',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$plazaNom = PlazasNominales::find($request->id);
		    	$plazaNom->nombrePlazaNominal = $request->nombre;
		    	$plazaNom->descripcionPlaza = $request->descripcion;
		    	$plazaNom->cantidadAprobadas = $request->cantidad;
		    	$plazaNom->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}





		/*************************************CATALOGO BANCOS**************************************************/
 public function indexBanco(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Bancos'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Bancos', 'url' => route('banco.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.bancos.index',$data);
		}

		public function  getDataRowsBanco(Request $request){
			$banco=Bancos::all();
			return Datatables::of($banco)
             ->addColumn('detalle', function ($dt) {
				   	return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idBanco.'\');" ><i class="fa fa-pencil"></i></a>';

						})

			->make(true);
		}
			public function nuevoBanco(){
	    $data = ['title' 			=> 'Nuevo banco'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Bancos', 'url' => route('banco.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.bancos.nuevo',$data);
		}
			public function storeBanco(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:80',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre del banco',

		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$banco = new Bancos;
		    	$banco->nombreBanco = $request->nombre;
		    	$banco->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
		public function getBanco(Request $request){
		    $id = $request->param;
		    $bancos =Bancos::find($id);
		    return response()->json($bancos);
		}
			public function editarBanco(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:80',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre' => 'nombre del banco',

		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$banco = Bancos::find($request->id);
		    	$banco->nombreBanco = $request->nombre;
		    	$banco->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		/*************************************CATALOGO EVALUACIONES**************************************************/
 public function indexEvaluacion(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Evaluaciones'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Evaluaciones', 'url' => route('evaluacion.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.evaluaciones.index',$data);
		}

		public function  getDataRowsEvaluacion(Request $request){
			$evaluaciones=Evaluaciones::whereNotNull('periodo');
			return Datatables::of($evaluaciones)

             ->addColumn('detalle', function ($dt) {
				   	return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idEvaluacion.'\');" ><i class="fa fa-pencil"></i></a>&nbsp;<a href="'.route('ver.evaluaciones.empleados',['idEvaluacion' =>Crypt::encrypt($dt->idEvaluacion)]).'" class="btn btn-xs btn-success btn-perspective" ><i class="fa fa-users"></i></a>';

						})

             ->addColumn('estado', function ($dt) {

						if($dt->activo == 1)
							return '<span class="label label-success">ACTIVO </span>';
						else
							return '<span class="label label-warning">INACTIVO</span>';

						})

			->make(true);
		}
			public function nuevaEvaluacion(){
	    $data = ['title' 			=> 'Nueva evaluación'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Evaluaciones', 'url' => route('evaluacion.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.evaluaciones.nuevo',$data);
		}

			public function storeEvaluacion(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:150',
	        	'fechaInicio'=>'required',
	        	'periodo'=>'required',
	        	'fechaFin'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre'=>'nombre de la evaluación',
	   		    'periodo'=>'periodo',
	        	'fechaInicio'=>'fecha de inicial',
	        	'fechaFin'=>'fecha fin',


		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$eva = new Evaluaciones;

		    	$eva->nombre = mb_strtoupper($request->nombre, 'UTF-8');
		    	$eva->periodo = $request->periodo;
		    	$eva->fechaInicio = $request->fechaInicio;
		    	$eva->fechaFin = $request->fechaFin;
		    	$eva->descripcion = mb_strtoupper($request->descripcion, 'UTF-8');
		    	$eva->activo = $request->estado;
		    	$eva->idUsuarioCrea = Auth::user()->idUsuario;
		    	$eva->fechaCreacion = Carbon::now();
		    	$eva->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
			public function getEvaluacion(Request $request){
		    $id = $request->param;
		    $eva =Evaluaciones::find($id);
		    return response()->json($eva);
		}
		public function editarEvaluacion(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:150',
	        	'fechaInicio'=>'required',
	        	'periodo'=>'required',
	        	'fechaFin'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre'=>'nombre de la evaluación',
	   		    'periodo'=>'periodo',
	        	'fechaInicio'=>'fecha de inicial',
	        	'fechaFin'=>'fecha fin',


		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$eva = Evaluaciones::find($request->id);
		    	$eva->nombre = mb_strtoupper($request->nombre, 'UTF-8');
		    	$eva->periodo = $request->periodo;
		    	$eva->fechaInicio = $request->fechaInicio;
		    	$eva->fechaFin = $request->fechaFin;
		    	$eva->descripcion = mb_strtoupper($request->descripcion, 'UTF-8');
		    	$eva->activo = $request->estado;
		    	$eva->idUsuarioModifica = Auth::user()->idUsuario;
		    	$eva->fechaModificacion = Carbon::now();
		    	$eva->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		/*******CATALOGO EVALUACIONES PERSONAL TEMPORAL*****************************/
		public function indexEvaluacionPersonalTemporal(){

	    	$data = ['title' 			=> 'Cat&aacute;logo de Evaluaciones Personal Temporal'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Evaluaciones Personal Temporal', 'url' => route('evaluacionPersonalTemp.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];

			return view('catalogos.evaluaciones.indexPersonalTemporal',$data);
		}

		public function  getDataRowsEvaluacionTemporal(Request $request){
			$evaluaciones=Evaluaciones::where('idEvaluacion',5);
			return Datatables::of($evaluaciones)

             ->addColumn('detalle', function ($dt) {
				   	return	'<a href="'.route('ver.evaluaciones.empleados.temporales',['idEvaluacion' =>Crypt::encrypt($dt->idEvaluacion)]).'" class="btn btn-xs btn-success btn-perspective" ><i class="fa fa-users"></i></a>';

						})

             ->addColumn('estado', function ($dt) {

						if($dt->activo == 1)
							return '<span class="label label-success">ACTIVO </span>';
						else
							return '<span class="label label-warning">INACTIVO</span>';

						})

			->make(true);
		}

		public function nuevaEvaluacionTemporal(){
	    $data = ['title' 			=> 'Nueva evaluación Personal Temporal'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Evaluaciones Personal Temporal', 'url' => route('evaluacionPersonalTemp.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.evaluaciones.nuevoTemporal',$data);
		}

		public function storeEvaluacionTemporal(Request $request){

			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:150'
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre'=>'nombre de la evaluación'

		    ]);

			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {

		    	if($request->id==""){//estamos creando
		    		$eva = new Evaluaciones;

			    	$eva->nombre = mb_strtoupper($request->nombre, 'UTF-8');
			    	$eva->descripcion = mb_strtoupper($request->descripcion, 'UTF-8');
			    	$eva->activo = $request->estado;
			    	$eva->idUsuarioCrea = Auth::user()->idUsuario;
			    	$eva->fechaCreacion = Carbon::now();
			    	$eva->save();

		    	}else{//estamos editando

		    		$eva = Evaluaciones::find($request->id);
		    		$eva->nombre = mb_strtoupper($request->nombre, 'UTF-8');
			    	$eva->descripcion = mb_strtoupper($request->descripcion, 'UTF-8');
			    	$eva->activo = $request->estado;
			    	$eva->idUsuarioModifica = Auth::user()->idUsuario;
			    	$eva->fechaModificacion = Carbon::now();
			    	$eva->save();

		    	}

			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}


			/*************************************CATALOGO ACTITUDES**************************************************/
 public function indexTipoActitud(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Actitudes'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Tipos de actitudes', 'url' => route('tipoActitud.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.tiposActitudes.index',$data);
		}

		public function  getDataRowsTipoActitud(Request $request){
			$tipoAct=TiposActitudes::all();
			return Datatables::of($tipoAct)

             ->addColumn('detalle', function ($dt) {
				   	return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idTipoActitud.'\');" ><i class="fa fa-pencil"></i></a>';

						})

             ->addColumn('estado', function ($dt) {

						if($dt->activo == 1)
							return '<span class="label label-success">ACTIVO</span>';
						else
							return '<span class="label label-warning">INACTIVO</span>';

						})

			->make(true);
		}
		public function nuevoTipoActitud(){
	    $data = ['title' 			=> 'Nuevo tipo de actitud'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Tipos de actitudes', 'url' => route('tipoActitud.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.tiposActitudes.nuevo',$data);
		}

			public function storeTipoActitud(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:200',
	        	'estado'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombre'=>'nombre de la evaluación',
	   		    'estado'=>'estado',

		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$tipo = new TiposActitudes;
		    	$tipo->nombreTipoActitud = $request->nombre;
		    	$tipo->activo = $request->estado;
		    	$tipo->idUsuarioCrea = Auth::user()->idUsuario;
		    	$tipo->fechaCreacion = Carbon::now();
		    	$tipo->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		public function getTipoActitud(Request $request){
			$id = $request->param;
			$tipoAct = TiposActitudes::find($id);
			return response()->json($tipoAct);
		}
		public function editarTipoActitud(Request $request){
			$v = Validator::make($request->all(),[
					'nombre'=>'required|max:200',
					'estado'=>'required'
				]);
			$v->setAttributeNames([
                   'nombre'=>'nombre del tipo de actitud',
                   'estado'=>'estado'
				]);
			if($v->fails()){
				$msg="<ul class='text-warning'>";
				foreach($v->messages()->all() as $err){
					$msg .="<li>$err</li>";
				}
				$msg.="</ul>";
				return $msg;
			}
			try{
				$tipo = TiposActitudes::find($request->id);
			    $tipo->nombreTipoActitud = $request->nombre;
		    	$tipo->activo = $request->estado;
		    	$tipo->idUsuarioModifica = Auth::user()->idUsuario;
		    	$tipo->fechaModificacion = Carbon::now();
		    	$tipo->save();

			}catch(Exception $e){
				DB::rollback();
				throw $e;
				return $e->getMessage();
			}
			return response()->json(['state'=>'success']);
		}


		/* Procedimientos para la tabla EstadoLaboral */

		public function indexEstadoLaboral(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Estados Laborales'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Estados Laborales', 'url' => route('estadoLaboral.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.estadoLaboral.index',$data);
		}

		public function  getDataRowsEstadoLaboral(Request $request){
			$estadosLaborales=EstadoLaboral::where("estado","=","A")->get();

			return Datatables::of($estadosLaborales)
				   ->addColumn('detalle', function ($dt) {
		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idEstadoLabor.'\');" ><i class="fa fa-pencil"></i></a> <a class="btn btn-xs btn-danger btn-perspective" onclick="eliminarEstLaboral(\''.$dt->idEstadoLabor.'\');" ><i class="fa fa-times"></i></a>';

						})

			->make(true);
		}

	    public function nuevaEstadoLaboral(){
	    $data = ['title' 			=> 'Nuevo Estado Laboral'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Estados Laborales', 'url' => route('estadoLaboral.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.estadoLaboral.nuevo',$data);
		}

		public function storeEstadoLaboral(Request $request){
			$v = Validator::make($request->all(),[
	        	'descripcionLaboral'=>'required|max:500',
				    ]);

	   		$v->setAttributeNames([
	   		    'descripcionLaboral' => 'Nombre del estado laboral',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$estadoLaboral = new EstadoLaboral;
		    	$estadoLaboral->idEstadoLabor = $estadoLaboral->getNextID();
		    	$estadoLaboral->descripcionLaboral = $request->descripcionLaboral;
		    	$estadoLaboral->estado = 'A';
		    	$estadoLaboral->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
		public function getEstadoLaboral(Request $request){
		    $idEstadoLabor = $request->param;
		    $estadoLaboral = EstadoLaboral::find($idEstadoLabor);
		    return response()->json($estadoLaboral);
		}
	    public function editarEstadoLaboral(Request $request){
	   		$v = Validator::make($request->all(),[
	        	'descripcionLaboral'=>'required|max:500',
				    ]);
	   		$v->setAttributeNames([
	   		    'descripcionLaboral' => 'Descripción Laboral',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$estadoLaboral = EstadoLaboral::find($request->id);
		    	$estadoLaboral->descripcionLaboral = $request->descripcionLaboral;
		    	$estadoLaboral->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		public function deleteEstadoLaboral(Request $request){
	   		$v = Validator::make($request->all(),[
	        	'idEstadoLabor'=>'required',
				    ]);
	   		$v->setAttributeNames([
	   		    'idEstadoLabor' => 'ID Estado laboral',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$estadoLaboral = EstadoLaboral::find($request->idEstadoLabor);
		    	$estadoLaboral->estado = "I";
		    	$estadoLaboral->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}


		/* Procedimientos para la tabla ClasificacionEmpleado (clasificacionApoyo) */

		public function indexClasificacionEmpleado(){

	    $data = ['title' 			=> 'Cat&aacute;logo de Clasificaciones de Empleados'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Clasificaciones de Empleados', 'url' => route('clasificacionEmpleado.listar')],
				 		['nom'	=>	'', 'url' => ''],

					]];
			return view('catalogos.clasificacionEmpleado.index',$data);
		}

		public function  getDataRowsClasificacionEmpleado(Request $request){
			$clasificacionesEmpleados = ClasificacionEmpleado::where("estado","=","A")->get();

			return Datatables::of($clasificacionesEmpleados)
				   ->addColumn('detalle', function ($dt) {
		              return	'<a class="btn btn-xs btn-success btn-perspective" onclick="editarInfo(\''.$dt->idClasificacion.'\');" ><i class="fa fa-pencil"></i></a> <a class="btn btn-xs btn-danger btn-perspective" onclick="eliminarClasificacionEmpleado(\''.$dt->idClasificacion.'\');" ><i class="fa fa-times"></i></a>';
						})
			->make(true);
		}

	    public function nuevaClasificacionEmpleado(){
	    $data = ['title' 			=> 'Nueva clasificacion'
					,'subtitle'			=> ''
					,'breadcrumb' 		=> [
				 		['nom'	=>	'Clasificaciones de Empleados', 'url' => route('clasificacionEmpleado.listar')],
				 		['nom'	=>	'Nuevo registro', 'url' => ''],

					]];
		return view('catalogos.clasificacionEmpleado.nuevo',$data);
		}

		public function storeClasificacionEmpleado(Request $request){
			$v = Validator::make($request->all(),[
	        	'nombreClasificacion'=>'required|max:500',
				    ]);

	   		$v->setAttributeNames([
	   		    'nombreClasificacion' => 'Nombre de la clasificación',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$clasificacionEmpleado = new ClasificacionEmpleado;
		    	$clasificacionEmpleado->idClasificacion = $clasificacionEmpleado->getNextID();
		    	$clasificacionEmpleado->nombreClasificacion = $request->nombreClasificacion;
		    	$clasificacionEmpleado->estado = 'A';
		    	$clasificacionEmpleado->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
		public function getClasificacionEmpleado(Request $request){
		    $idClasificacion = $request->param;
		    $clasificacionEmpleado = ClasificacionEmpleado::find($idClasificacion);
		    return response()->json($clasificacionEmpleado);
		}
	    public function editarClasificacionEmpleado(Request $request){
	   		$v = Validator::make($request->all(),[
	        	'nombreClasificacion'=>'required|max:500',
				    ]);
	   		$v->setAttributeNames([
	   		    'nombreClasificacion' => 'Descripción Laboral',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$clasificacionEmpleado = ClasificacionEmpleado::find($request->id);
		    	$clasificacionEmpleado->nombreClasificacion = $request->nombreClasificacion;
		    	$clasificacionEmpleado->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}

		public function deleteClasificacionEmpleado(Request $request){
	   		$v = Validator::make($request->all(),[
	        	'idClasificacion'=>'required',
				    ]);
	   		$v->setAttributeNames([
	   		    'idClasificacion' => 'ID Clasificación',
		    ]);
			if ($v->fails())
		    {
		    	$msg = "<ul class='text-warning'>";
		    	foreach ($v->messages()->all() as $err) {
		    	 	$msg .= "<li>$err</li>";
		    	}
		    	$msg .= "</ul>";
		        return $msg;
		    }
		    try {
		    	$clasificacionEmpleado = ClasificacionEmpleado::find($request->idClasificacion);
		    	$clasificacionEmpleado->estado = "I";
		    	$clasificacionEmpleado->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
}
