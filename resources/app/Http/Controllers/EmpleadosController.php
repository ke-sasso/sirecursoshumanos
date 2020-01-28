<?php namespace App\Http\Controllers;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use App\Http\Requests\SeguroRequest;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Auth;
use Validator;
use DB;
use Session;
use Redirect;
use File;
use Crypt;
use Response;
use DateTime;
use App\Unidades;
use App\CatEmpleados;
use App\PlazasFuncionales;
use App\PlazasNominales;
use App\CatPlazasFuncionales;
use App\EstadoLaboral;
use App\ClasificacionEmpleado;
use App\DetalleClasificacionEmpleado;
use App\Models\rrhh\MarcasEmpleado;
use App\Models\rrhh\VwAllPermisos;
use App\Models\rrhh\rh\Municipios;
use App\Models\rrhh\rh\GrupoSanguineo;
use App\Models\rrhh\rh\InformacionEstudio;
use App\Models\rrhh\rh\InformacionMedica;
use App\Models\rrhh\rh\HistorialLaboral;
use App\Models\rrhh\rh\TipoEstudio;
use App\Models\rrhh\rh\InstitucionesEducativas;
use App\Models\rrhh\rh\InformacionSanciones;
use App\Models\rrhh\rh\ContactosEmpleados;
use App\Models\rrhh\rh\Parentesco;
use App\Models\rrhh\rh\Bancos;
use App\Models\rrhh\rh\Departamentos;
use App\Models\rrhh\rh\TiposContratos;
use App\Models\rrhh\edc\Evaluaciones;
use App\Models\rrhh\rh\DocumentosEmpleado;
class EmpleadosController extends Controller {

	private $url=null;

	public function __construct(){
        $this->middleware('auth');
        $this->url = 'Y:\ECM\urh\eepl';
    }


	public function getMarcaciones($idEmpleado){
	    $marcacionesEmp = MarcasEmpleado::getHistMarcacionEmpleado($idEmpleado);


		$data=array();
		for($i=0;$i<count($marcacionesEmp);$i++) {
				 if(date('H',strtotime($marcacionesEmp[$i]['FechaMarca']))>=13)
				 {
				 	$data[$i]['title']= date('H:i',strtotime($marcacionesEmp[$i]['FechaMarca'])).' - '.'SALIDA';
				 	$data[$i]['color']='#00CC66';
				 }
				 else{
				 	$data[$i]['title']= date('H:i',strtotime($marcacionesEmp[$i]['FechaMarca'])).' - '.'ENTRADA';
				 	$data[$i]['color']='#0066CC';

				 }

				$data[$i]['start']= $marcacionesEmp[$i]['FechaMarca'];
		}

		return json_encode($data);

	}
	public function getComboboxMunicipiosAJAX(Request $request)
	{
		$result = "";
		foreach (Municipios::getList($request->deparamento) as $key => $value) {
			$result .= "<option value='$key'>$value</option>";
		}
		return $result;
	}
	public function verExpedienteEmpleado($idEmpleado){
        $idEmpleado=Crypt::decrypt($idEmpleado);
        $persona = CatEmpleados::find($idEmpleado);
        $permisos = VwAllPermisos::where('idEmpleadoCrea',$idEmpleado)->whereIn('idEstadoSol',[2,3,4,6])
					->select('motivo','fechaDesde','fechaHasta','nombreEstado','fechaApruebaDenegar')->get();

		/**Funciones para capturar la información del EMPLEADO**/

		$data = ['title' 			=> 'Expediente Personal Laboral'
				,'subtitle'			=> ''
				,'infoContacto'     => ContactosEmpleados::getContactos($persona->dui)
				,'infoEstudio'		=> InformacionEstudio::getList($persona->dui)
				,'breadcrumb' 		=> [

					['nom'	=>	'Búsqueda de empleados', 'url' => route('index.empleados')],
					['nom'	=>	'Información empleado', 'url' => '#']
				]];
		    $data['persona'] = $persona;
		    $data['grupoSangre'] = GrupoSanguineo::getList();
		    $data['bancos'] = Bancos::getList();
		    $data['plazasFun'] = PlazasFuncionales::all();
		    $data['plazasNom'] = PlazasNominales::all();
			$data['listaDept'] = Departamentos::getList();
			$data['listaMun'] = Municipios::getList($persona->direccionDepartamentoid);
			$data['listaMunDUI'] = Municipios::getList($persona->departamentoDUI);
			if((InformacionMedica::where('duiEmpleado',$persona->dui)->count()) > 0) $data['infoMedica']= InformacionMedica::getList($persona->dui);
			$data['infoSanciones']	=InformacionSanciones::where('duiEmpleado','=',trim($persona->dui))->where('estado','A')->get();
			$data['permisos'] = $permisos;
			$data['infoLaboral']=HistorialLaboral::getListHistorialEmpleado($persona->dui);
			$data['unidades'] = Unidades::all();
			$evaluacion = Evaluaciones::getEvaluacionHistorial($idEmpleado);
			for ($i=0; $i < count($evaluacion); $i++) {
				$evaluacion[$i]->fechaCreacion=date_create($evaluacion[$i]->fechaCreacion)->format('d-m-Y');
			}
			$data['evaluacion']=$evaluacion;


		     if($persona->avatar==null){
		        $data['img_e'] = '';
		     }else{
		       if(file_exists($persona->avatar)){
		       			$img=  base64_encode(File::get($persona->avatar));
			   			$data['img_e'] = $img;
		       }else{
		                $data['img_e'] = '';
		       }

			}

          	$data['tiposContratos']= TiposContratos::all();
          	$data['clasificacionEmpleados'] = ClasificacionEmpleado::where("estado","=","A")->get();
          	$data['detalleClasificacionEmpleados'] = DetalleClasificacionEmpleado::getDetalleClasificacion($idEmpleado);
          	$data['estadosLaborales']= EstadoLaboral::where("estado","=","A")->get();
          	$data['docPersona'] = $persona->documentosPersonal()->where('estado',1)->get();

		   return view('empleados.expedientePersonal',$data);


	}
	public function editarEmpleado(Request $request){

			$v = Validator::make($request->all(),[
	        	'txtNombres'=>'required|max:250',
	        	'txtApellidos'=>'required|max:250',
	        	'txtDUI'=>'required|min:10',
	        	'txtSalario'=>'min:0'
				    ]);

	   		$v->setAttributeNames([
	   		    'txtNombres' => 'nombres del empleado',
	   		    'txtApellidos'=>'apellidos del empleado',
	        	'txtDUI'=>'dui del empleado',
	        	'txtSalario'=>'salario del empleado'
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

		    if($request->cmbTipoContrato==4){//tipo Contrato Pruebas
		    	if($request->inicioPruebas==''||$request->finPruebas==''){
		    		return $msg = "<ul class='text-warning'><li>Debe Ingresar la Fecha de Inicio y Fecha Fin de las pruebas</li></ul>";
		    	}

		    }

		    DB::beginTransaction();

		    try {

		    	   $empleado = CatEmpleados::find($request->txtCodEmpleado);
                   $empleado->nombresEmpleado = mb_strtoupper($request->txtNombres, 'UTF-8');
                   $empleado->apellidosEmpleado = mb_strtoupper($request->txtApellidos, 'UTF-8');
                   $empleado->nombresISSS = mb_strtoupper($request->txtNombresISSS, 'UTF-8');
                   $empleado->apellidosISSS = mb_strtoupper($request->txtApellidosISSS, 'UTF-8');

                   $empleado->fechaNacimiento = $request->txtFechaNacimiento;
                   $empleado->email = strtolower($request->txtEmail);
                   $empleado->celular = $request->txtTelMovil;
                   $empleado->telefonoCasa = $request->txtTelFijo;
                   $empleado->direccionActual = $request->txtDireccion;
                   $empleado->direccionDepartamentoid = $request->txtDepartamento;
                   $empleado->direccionMunicipioid = $request->txtMunicipio;

                   $empleado->direccionDUI = $request->txtDireccionDUI;
                   $empleado->departamentoDUI = $request->txtDepartamentoDUI;
                   $empleado->municipioDUI = $request->txtMunicipioDUI;

                   $empleado->nit= $request->txtNIT;
                   if(strlen($request->txtPasaporte)!=0) $empleado->pasaporte = $request->txtPasaporte;
                   $empleado->afp = $request->txtAFP;
                   $empleado->isss = $request->txtISSS;
                   $empleado->sexo = $request->cmbSexo;
                  $empleado->idPlazaFuncional = $request->idPlazaFun;
                   if($request->idPlazaNom != 'NULL'){
                   $empleado->idPlazaNominal = $request->idPlazaNom;
                   }
                   $empleado->asegurado = $request->cmbAsegurado;
                   $empleado->estadoId = $request->cmbEstadoEmp;
                   $empleado->contratoId = $request->cmbTipoContrato;

                   $empleado->idEstadoLaboral = $request->cmbEstadoLaboral;

                   if(strlen($request->txtCtaBancaria)!=0) $empleado->cuentaBancaria = $request->txtCtaBancaria;
                   $empleado->idBanco = $request->txtBanco;
                   if($request->txtSalario != ''){
                   $empleado->salario= $request->txtSalario;
               	 	}
               	 	 if($request->inicioContrato != ''){
               	   	$empleado->fechaInicioContrato = $request->inicioContrato;
               	   }
               	   if($request->finContrato != ''){
               	   	$empleado->fechaFinContrato = $request->finContrato;
               	   }

               	   if($request->cmbTipoContrato==4){//tipo de contrato Pruebas
               	   	$empleado->fechaInicioPruebas = $request->inicioPruebas;
               	   	$empleado->fechaFinPruebas = $request->finPruebas;
               	   }
               	   $empleado->usuarioModificacion=Auth::user()->idUsuario.'@'.$request->ip();
                   $empleado->save();

                   DetalleClasificacionEmpleado::actualizarClasificacion(
                   						$request->cmbClasificacionEmpleado,$empleado->idEmpleado);

				   //-------------SUBIR FOTOGRAFÍA DE EMPLEADO-----------
		    	       $nombre= 'avatar';
		      		$urlPrincipal =$this->url;
		      	    $path= $urlPrincipal.'\\'.$empleado->dui;
				    $file= $request->file('file');
				    $idEmpleado = $request->txtCodEmpleado;

				    if(!empty($file)){
					//si hay archivos crear la ruta con el id del usuario
					$filesystem= new Filesystem();
				    if($filesystem->exists($path)){

					    if($filesystem->isWritable($path)){
						$carpeta=$path.'\\'.$nombre;
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();

						$name= $file->getClientOriginalName();
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora

						$archivo = CatEmpleados::find($idEmpleado);
						$archivo->avatar=$carpeta.'\\'.$name;
						$archivo->tipoImagen=$type;
						$archivo->save();
					   }else{
					   		DB::rollback();
							return " Error al subir la fotorafía";
					   }


				  }else{
				  	    $carpeta=$path.'\\'.$nombre;
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();
						$name= $file->getClientOriginalName(); ;
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora


						$archivo = CatEmpleados::find($idEmpleado);
						$archivo->avatar=$carpeta.'\\'.$name;
						$archivo->tipoImagen=$type;
						$archivo->save();
				  }
				}
				//----------------------------------



			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			DB::commit();
			return response()->json(['state' => 'success']);

	}
	public function nuevoEmpleado(){

	  $data = ['title' 			=> 'NUEVO EMPLEADO'
				,'subtitle'			=> ''

				,'breadcrumb' 		=> [

					['nom'	=>	'Ficha para nuevo empleado', 'url' => ''],
					['nom'	=>	'', 'url' => '#']
				]];

		    $data['bancos'] = Bancos::getList();
		    $data['plazasFun'] = PlazasFuncionales::all();
		    $data['plazasNom'] = PlazasNominales::all();
			$data['listaDept'] = Departamentos::getList();
			$data['listaMun'] = Municipios::getList(1);
			$data['tiposContratos']=TiposContratos::all();
			$data['clasificacionEmpleados']= ClasificacionEmpleado::where("estado","=","A")->get();
          	$data['estadosLaborales']= EstadoLaboral::where("estado","=","A")->get();
		return view('empleados.nuevoEmpleado',$data);
	}
	public function storeEmpleado(Request $request){


			$v = Validator::make($request->all(),[
			    'txtCodEmpleado'=>'required|numeric',
	        	'txtNombres'=>'required|max:250',
	        	'txtApellidos'=>'required|max:250',
	        	'txtFechaNacimiento'=>'required',
	            'txtEmail' => 'required|email',
	            'txtDireccion'=>'required',
	            'txtDireccionDUI'=>'required',
	            'txtDUI'=>'required|min:10',
	            'txtNIT'=>'required',
	            'txtISSS'=>'sometimes|numeric|min:4',
	            'idPlazaFun' => 'required|numeric',
	            'idPlazaNom' => 'required|numeric',
	            'cmbEstadoLaboral' => 'required|numeric',
	        	'txtSalario'=>'min:0'

				    ]);

	   		$v->setAttributeNames([
	   			'txtCodEmpleado'=>'código del empleado',
	   		    'txtNombres' => 'nombres del empleado',
	   		    'txtApellidos'=>'apellidos del empleado',
	        	'txtDUI'=>'dui del empleado',
	        	'txtSalario'=>'salario del empleado',
	        	'txtFechaNacimiento'=>'fecha de nacimiento del empleado',
	        	'txtDireccion'=>'dirección del empleado',
	        	'txtDireccionDUI'=>'dirección según DUI',
	        	 'txtDUI'=>'DUI del empleado',
	        	 'txtNIT'=>'NIT del empleado',
	        	 'txtISSS'=>'ISSS del empleado',
	        	'txtEmail' => 'correo electrónico',
	        	 'idPlazaFun' => 'plaza funcional',
	        	 'cmbEstadoLaboral' => 'Estado laboral',
	            'cmbClasificacionEmpleado' => 'Clasificación empleado',
	            'idPlazaNom' => 'plaza nominal'
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

		    if($request->cmbTipoContrato==4){//tipo Contrato Pruebas
		    	if($request->inicioPruebas==''||$request->finPruebas==''){
		    		return $msg = "<ul class='text-warning'><li>Debe Ingresar la Fecha de Inicio y Fecha Fin de las pruebas</li></ul>";
		    	}

		    }

		     if((CatEmpleados::where('idEmpleado',$request->txtCodEmpleado)->count())>0)return "<ul class='text-warning'><li>Ya existe un empleado con este ID: ".$request->txtCodEmpleado."</li></ul>";
		     if((CatEmpleados::where('dui',$request->txtDUI)->count())>0)return "<ul class='text-warning'><li>Ya existe un empleado con este DUI: ".$request->txtDUI."</li></ul>";
		      if((CatEmpleados::where('nit',$request->txtNIT)->count())>0)return "<ul class='text-warning'><li>Ya existe un empleado con este NIT: ".$request->txtNIT."</li></ul>";

		     if(strlen($request->txtTelFijo)==0 && strlen($request->txtTelMovil)==0) return "<ul class='text-warning'><li>Debe ingresar al menos un teléfono de contacto personal</li></ul>";
		    DB::beginTransaction();

		    try {

		    	   $empleado = new CatEmpleados;
		    	   $empleado->idEmpleado = $request->txtCodEmpleado;
                   $empleado->nombresEmpleado = mb_strtoupper($request->txtNombres, 'UTF-8');
                   $empleado->apellidosEmpleado = mb_strtoupper($request->txtApellidos, 'UTF-8');
                   $empleado->nombresISSS = mb_strtoupper($request->txtNombres, 'UTF-8');
                   $empleado->apellidosISSS = mb_strtoupper($request->txtApellidos, 'UTF-8');

                   $empleado->fechaNacimiento = $request->txtFechaNacimiento;
                   $empleado->dui = $request->txtDUI;
                   $empleado->email = strtolower($request->txtEmail);
                   if(strlen($request->txtTelMovil)!=0) $empleado->celular = $request->txtTelMovil;
                   if(strlen($request->txtTelFijo)!=0) $empleado->telefonoCasa = $request->txtTelFijo;
                   $empleado->direccionActual = $request->txtDireccion;
                   $empleado->direccionDepartamentoid = $request->txtDepartamento;
                   $empleado->direccionMunicipioid = $request->txtMunicipio;
                   $empleado->direccionDUI = $request->txtDireccionDUI;
                   $empleado->departamentoDUI = $request->txtDepartamentoDUI;
                   $empleado->municipioDUI = $request->txtMunicipioDUI;
                   $empleado->nit= $request->txtNIT;
                   if(strlen($request->txtPasaporte)!=0) $empleado->pasaporte = $request->txtPasaporte;
                   $empleado->afp = $request->txtAFP;
                   $empleado->isss = $request->txtISSS;
                   $empleado->sexo = $request->cmbSexo;
                   $empleado->idPlazaFuncional = $request->idPlazaFun;
                   if($request->idPlazaNom != 'NULL'){
                   $empleado->idPlazaNominal = $request->idPlazaNom;
                   }
                   $empleado->asegurado = $request->cmbAsegurado;
                   $empleado->estadoId = $request->cmbEstadoEmp;
                   $empleado->contratoId = $request->cmbTipoContrato;

                   $empleado->idEstadoLaboral = $request->cmbEstadoLaboral;

                   if(strlen($request->txtCtaBancaria)!=0) $empleado->cuentaBancaria = $request->txtCtaBancaria;
                   $empleado->idBanco = $request->txtBanco;
                   if($request->txtSalario != ''){
                   $empleado->salario= $request->txtSalario;
               	 	}
               	   if($request->inicioContrato != ''){
               	   	$empleado->fechaInicioContrato = $request->inicioContrato;
               	   }
               	   if($request->finContrato != ''){
               	   	$empleado->fechaFinContrato = $request->finContrato;
               	   }

               	   if($request->cmbTipoContrato==4){//tipo de contrato Pruebas
               	   	$empleado->fechaInicioPruebas = $request->inicioPruebas;
               	   	$empleado->fechaFinPruebas = $request->finPruebas;
               	   }
               	   $empleado->usuarioCreacion=Auth::user()->idUsuario.'@'.$request->ip();
                   $empleado->save();

                   DetalleClasificacionEmpleado::actualizarClasificacion(
                   						$request->cmbClasificacionEmpleado,$request->txtCodEmpleado);

                 /*  if(count($request->cmbClasificacionEmpleado)){
						foreach ($request->cmbClasificacionEmpleado as $ce) {
				            $detalleClasificacion = new DetalleClasificacionEmpleado;
				            $detalleClasificacion->idEmpleado = $request->txtCodEmpleado;
				            $detalleClasificacion->idClasificacionApoyo = $ce;
				            $detalleClasificacion->save();
			        	}
					}
                 */
				   //-------------SUBIR FOTOGRAFÍA DE EMPLEADO-----------

				    $nombre= 'avatar';
		      		$urlPrincipal =$this->url;
		      	    $path= $urlPrincipal.'\\'.$empleado->dui;
				    $file= $request->file('fileAvatar');
				    $idEmpleado = $request->txtCodEmpleado;

				    if(!empty($file)){
					//si hay archivos crear la ruta con el id del usuario
					$filesystem= new Filesystem();
				    if($filesystem->exists($path)){

					    if($filesystem->isWritable($path)){
						$carpeta=$path.'\\'.$nombre;
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();

						$name= $file->getClientOriginalName();
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora

						$archivo = CatEmpleados::find($idEmpleado);
						$archivo->avatar=$carpeta.'\\'.$name;
						$archivo->tipoImagen=$type;
						$archivo->save();
					   }else{
					   		DB::rollback();
							return " Error al subir la fotorafía";
					   }


				  }else{
				  	    $carpeta=$path.'\\'.$nombre;
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();
						$name= $file->getClientOriginalName(); ;
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora


						$archivo = CatEmpleados::find($idEmpleado);
						$archivo->avatar=$carpeta.'\\'.$name;
						$archivo->tipoImagen=$type;
						$archivo->save();
				  }
				}
				//----------------------------------



			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			DB::commit();
			return response()->json(['state' => 'success', 'id' => Crypt::encrypt($idEmpleado)]);

	}
	public function getContactosEmpleado(Request $request){
		$id = $request->param;
		$contacto = ContactosEmpleados::find($id);
		return response()->json($contacto);

	}
	public function getParentescoEmpleado(){
		$parentesco = Parentesco::all();
		return response()->json($parentesco);
	}
	public function editarContactoEmp(Request $request){

			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:250',
	        	'idParentesco'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		   'nombre'=>'nombre del pariente',
	        	'idParentesco'=>'parentesco',
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
		      $contacto = ContactosEmpleados::find($request->idContacto);
		      $contacto->nombre = $request->nombre;
		      $contacto->parentesco = $request->idParentesco;
		      $contacto->celular = $request->telMovil;
		      $contacto->telefonoFijo = $request->telFijo;
		      $contacto->direccion = $request->direccion;
		      $contacto->usuModificacion = Auth::User()->idUsuario;
		      $contacto->fechaModificacion = Carbon::now();
		      $contacto->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
	public function getInfoEstudio(Request $request){
		$id = $request->param;
		$infoEstudio = InformacionEstudio::find($id);
		return response()->json($infoEstudio);

	}
	public function getTipoEstudio(){
		$tipos = TipoEstudio::all();
		return response()->json($tipos);
	}
	public function getInstitucionesEstudio(){
		$instituciones = InstitucionesEducativas::getInstituciones();
		return response()->json($instituciones);
	}
 	public function editarEstudiosEmp(Request $request){

			$v = Validator::make($request->all(),[
	        	'titulo'=>'required|max:100',
	        	'anno'=>'required|max:4',
				    ]);

	   		$v->setAttributeNames([
	   		  'titulo'=>'título del empleado',
	        	'anno'=>'año',
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
		    	$estudio = InformacionEstudio::find($request->idEstudio);
		    	$estudio->tipoEstudio = $request->idTipo;
		    	if($request->idInstitucion!='NULL'){
		    	$estudio->institucionIdestudio = $request->idInstitucion;
		    	}
		    	$estudio->lugar = $request->lugar;
		    	$estudio->titulo = $request->titulo;
		    	$estudio->annio = $request->anno;
		     	$estudio->usuModificacion = Auth::User()->idUsuario;
		      	$estudio->fechaModificacion = Carbon::now();
		      	$estudio->save();




		      	    $nombre= 'titulos';
		      		$urlPrincipal =$this->url;
		      	    $path= $urlPrincipal.'\\'.$estudio->duiEmpleado;
				    $file= $request->file('fileEstudio');
                    $fileExtension = $request->file('fileEstudio')->extension();
				    $idInfoEstudio = $estudio->id;
				    $titulo = $request->titulo;
				    if(!empty($file)){
					//si hay archivos crear la ruta con el id del usuario
					$filesystem= new Filesystem();
				    if($filesystem->exists($path)){

					    if($filesystem->isWritable($path)){
						$carpeta=$path.'\\'.$nombre.'\\';
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();

                        $fechaArchivo = date('Ymd');
                        $name= $fechaArchivo.$request->idTipoNuevo.$estudio->institucionIdestudio.'_'.$idInfoEstudio.'.'.$fileExtension;
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora

						$archivo = InformacionEstudio::find($idInfoEstudio);
						$archivo->urlDocumento=$carpeta.'\\'.$name;
						//$archivo->tipoImagen=$type;
						$archivo->save();
					   }else{
					   		DB::rollback();
							return " Error al subir la fotorafía";
					   }


				  }else{
				  	    $carpeta=$path.'\\'.$nombre;
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();
                        $fechaArchivo = date('Ymd');
                        $name= $fechaArchivo.$request->idTipoNuevo.$estudio->institucionIdestudio.'_'.$idInfoEstudio.'.'.$fileExtension;
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora

						$archivo = InformacionEstudio::find($idInfoEstudio);
						$archivo->urlDocumento=$carpeta.'\\'.$name;
						//$archivo->tipoImagen=$type;
						$archivo->save();

				  }
				}


			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
	public function editarMedicaEmp(Request $request){

			$v = Validator::make($request->all(),[
	        	'txtGrupo'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		  'txtGrupo'=>'tipo de sangre',
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

		    	$grupo = InformacionMedica::find($request->idGrupo);
		    	$grupo->alergias = $request->txtMedicaAlergias;
		    	$grupo->tipoSangre = $request->txtGrupo;
		    	$grupo->medicamentoPermanente = $request->txtMedicaMedPerma;
		     	$grupo->usuModificacion = Auth::User()->idUsuario;
		      	$grupo->fechaModificacion = Carbon::now();
		      	$grupo->save();

			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
    public function getInfoSanciones(Request $request){
    	$id = $request->param;
		$sancion = InformacionSanciones::find($id);

		return response()->json($sancion);
	}
	public function editarSancionEmp(Request $request){

			$v = Validator::make($request->all(),[
				'idSancion' => 'required',
	        	'idTipoSancion'=>'required',
	        	'fecha'=>'required',
	        	'motivo'=>'required',
	        	'descripcion'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		  'idSancion' => 'id sancion',
	   		  'idTipoSancion'=>'tipo de sanción',
	   		  'fecha'=>'fecha',
	   		  'motivo'=>'motivo',
	   		  'descripcion'=>'descripcion',
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
                $file = $request->file('pdfAmonestacion');
                $datetime = Carbon::now();
                $fecha = $request->fecha;
                $fechaPre = $request->fechaPrescripcion;
		    	$sancion = InformacionSanciones::find($request->idSancion);
		    	$urlFile = '';
		    	$filename = '';
                if(!empty($file))
                {
                    $path = $this->url.'\\'.$sancion->duiEmpleado;
                    if (!File::isDirectory($path))
                    {
                        File::makeDirectory($path,0777,true,true);
                    }
                    if(!File::isDirectory($path.'\\Sanciones'))
                    {
                        File::makeDirectory($path.'\\Sanciones',0777,true,true);
                    }
                    $urlFile = $path.'\\Sanciones\\';
                    $filename= 'amonestacion-'.$request->idSancion.'.pdf';
                    $file->move($urlFile,$filename);

                }
		    	$sancion->tipoId = $request->idTipoSancion;
		    	$sancion->fecha = $fecha." ".$datetime->toTimeString();
		    	$sancion->fechaPrescripcion = $fechaPre." ".$datetime->toTimeString();
		    	$sancion->motivo = $request->motivo;
		    	$sancion->descripcion = $request->descripcion;
		    	$sancion->pdfSancion = $urlFile.$filename;
		     	$sancion->usuModificacion = Auth::User()->idUsuario;
		      	$sancion->fechaModificacion = Carbon::now();
		      	$sancion->save();

			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
    public function deleteSancion(Request $rq)
    {
        $response = ['state'=>'error'];
        if($rq->has('idSancion'))
        {
            $sancion = InformacionSanciones::find($rq->idSancion);
            $sancion->estado = 'I';
            $sancion->save();
            $response = ['state'=>'success'];
        }
        echo json_encode($response);
    }
	public function nuevoContactoEmp(Request $request){

			$v = Validator::make($request->all(),[
	        	'nombre'=>'required|max:250',
	        	'idParentescoNuevo'=>'required',
				    ]);

	   		$v->setAttributeNames([
	   		   'nombre'=>'nombre del pariente',
	        	'idParentescoNuevo'=>'parentesco',
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

		    if($request->duiEmpleado=='' || $request->duiEmpleado==NULL){return "<ul class='text-warning'><li>El empleado no posee DUI para guardar registro</li></ul>";}
		    try {
		      $contacto = new ContactosEmpleados;
		      $contacto->nombre = $request->nombre;
		      $contacto->duiEmpleado =$request->duiEmpleado;
		      $contacto->parentesco = $request->idParentescoNuevo;
		      $contacto->celular = $request->telMovil;
		      $contacto->telefonoFijo = $request->telFijo;
		      $contacto->direccion = $request->direccion;
		      $contacto->usuCreacion = Auth::User()->idUsuario;
		      $contacto->fechaCreacion = Carbon::now();
		      $contacto->save();
			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
    public function getInsti(Request $request){
            $query = (ucwords($request->q));

            if(!$query && $query == '') return response()->json(array(), 400);

            $data = InstitucionesEducativas::buscarInstitucion($query);

            return response()->json(array('data'=>$data));
        }
    public function nuevoEstudioEmp(Request $request){

			$v = Validator::make($request->all(),[
	        	'titulo'=>'required|max:100',
	        	'anno'=>'required|max:4',
	        	'idInstitucionNuevo'=>'required'
				    ]);

	   		$v->setAttributeNames([
	   		  'titulo'=>'título del empleado',
	        	'anno'=>'año',
	        	'idInstitucionNuevo'=>'institución de estudio'

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
		   if($request->duiEmpleado=='' || $request->duiEmpleado==NULL){return "<ul class='text-warning'><li>El empleado no posee DUI para guardar registro</li></ul>";}
		    try {
		    	$estudio = new InformacionEstudio;
		    	$estudio->duiEmpleado = $request->duiEmpleado;
		    	$estudio->tipoEstudio = $request->idTipoNuevo;
		    	$estudio->institucionIdestudio = $request->idInstitucionNuevo;
		    	$estudio->lugar = $request->lugar;
		    	$estudio->titulo = $request->titulo;
		    	$estudio->annio = $request->anno;
		     	$estudio->usuCreacion = Auth::User()->idUsuario;
		      	$estudio->fechaCreacion= Carbon::now();
		      	$estudio->save();


                      $nombre= 'titulos';
		      		$urlPrincipal =$this->url;
		      	    $path= $urlPrincipal.'\\'.$estudio->duiEmpleado;
				    $file= $request->file('fileEstudiosNew');
                    $fileExtension = $request->file('fileEstudiosNew')->extension();
				    $idInfoEstudio = $estudio->id;
				    $titulo = $request->titulo;
				    if(!empty($file)){
					//si hay archivos crear la ruta con el id del usuario
					$filesystem= new Filesystem();
				    if($filesystem->exists($path)){

					    if($filesystem->isWritable($path))
					    {
                            $carpeta=$path.'\\'.$nombre.'\\';
                            //crea la nueva carpeta
                            File::makeDirectory($carpeta, 0777, true, true);
                            // se guadarn en el disco
                            //dd($file->getClientOriginalName());
                            //$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();
                            $fechaArchivo = date('Ymd');
                            $name= $fechaArchivo.$request->idTipoNuevo.$request->idInstitucionNuevo.'_'.$idInfoEstudio.'.'.$fileExtension;
                            $type = $file->getMimeType();
                            $file->move($carpeta,$name);

                            //se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora

                            $archivo = InformacionEstudio::find($idInfoEstudio);
                            $archivo->urlDocumento=$carpeta.'\\'.$name;
                            //$archivo->tipoImagen=$type;
                            $archivo->save();
					    }
					    else{
					   		DB::rollback();
							return " Error al subir la fotorafía";
					   }


				  }else{
				  	    $carpeta=$path.'\\'.$nombre.'\\';
						//crea la nueva carpeta
						File::makeDirectory($carpeta, 0777, true, true);
						// se guadarn en el disco
						//dd($file->getClientOriginalName());
						//$name= Auth::user()->apellidosUsuario .$file1->getClientOriginalName();
                        $fechaArchivo = date('Ymd');
                        $name= $fechaArchivo.$request->idTipoNuevo.$request->idInstitucionNuevo.'_'.$idInfoEstudio.'.'.$fileExtension;
						$type = $file->getMimeType();
						$file->move($carpeta,$name);

						//se enlanza cada archivo a su bitacora en la tabla ArchivoBitacora

						$archivo = InformacionEstudio::find($idInfoEstudio);
						$archivo->urlDocumento=$carpeta.'\\'.$name;
						//$archivo->tipoImagen=$type;
						$archivo->save();

				  }
				}


			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
    public function nuevaSancionEmp(Request $request){
        $v = Validator::make($request->all(),[
            'idTipoSancion'=>'required',
            'fecha'=>'required',
            'motivo'=>'required',
            'descripcion'=>'required',
                ]);

        $v->setAttributeNames([
          'idTipoSancion'=>'tipo de sanción',
          'fecha'=>'fecha',
          'motivo'=>'motivo',
          'descripcion'=>'descripcion',
        ]);

        $file = $request->file('pdfAmonestacion');

        if ($v->fails())
        {
            $msg = "<ul class='text-warning'>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return $msg;
        }
       if($request->duiEmpleado=='' || $request->duiEmpleado==NULL){return "<ul class='text-warning'><li>El empleado no posee DUI para guardar registro</li></ul>";}
        try {
            $datetime = Carbon::now();
            $fecha = $request->fecha;
            $fechaPre = $request->fechaPrescripcion;
            $urlFile = '';
            $filename = '';
            $sancion = new InformacionSanciones;
            $lastId = $sancion::all()->last()->id +1;
            if(!empty($file))
            {
                $path = $this->url.'\\'.$request->duiEmpleado;
                $fs = new Filesystem();
                if (!File::isDirectory($path))
                {
                    File::makeDirectory($path,0777,true,true);
                }
                if(!File::isDirectory($path.'\\Sanciones'))
                {
                    File::makeDirectory($path.'\\Sanciones',0777,true,true);
                }
                $urlFile = $path.'\\Sanciones\\';
                $filename= 'amonestacion-'.$lastId.'.pdf';
                $file->move($urlFile,$filename);

            }
            $sancion->id = $lastId;
            $sancion->duiEmpleado = $request->duiEmpleado;
            $sancion->tipoId = $request->idTipoSancion;
            $sancion->fecha = $fecha." ".$datetime->toTimeString();
            $sancion->fechaPrescripcion = $fechaPre." ".$datetime->toTimeString();
            $sancion->motivo = $request->motivo;
            $sancion->descripcion = $request->descripcion;
            $sancion->pdfSancion = $urlFile.$filename;
            $sancion->usuCreacion = Auth::User()->idUsuario;
            $sancion->fechaCreacion = Carbon::now();
            $sancion->save();

        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }
        return response()->json(['state' => 'success']);

}
	public function eliminarInfoLaboral(Request $request){

			$v = Validator::make($request->all(),[
	        	'idInfoLaboral'=>'required'
			]);

	   		$v->setAttributeNames([
	   		  'idInfoLaboral'=>'id de informaci? laboral'
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
		    	$infoLaboral = HistorialLaboral::find($request->idInfoLaboral);
		      	$infoLaboral->estado = 'E';
		      	$infoLaboral->usuModificacion = Auth::User()->idUsuario;
		      	$infoLaboral->fechaModificacion = Carbon::now();
		      	$infoLaboral->save();

			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);
		}
    public function getInfoLaboral(Request $request){
        $id = $request->param;
        $infoLaboral = HistorialLaboral::find($id);
        return response()->json($infoLaboral);

    }
    public function editarInfoLaboral(Request $request){

        $v = Validator::make($request->all(),[
            'idUnidad'=>'required',
            'idPadre'=>'required',
            'dui'=>'required',

                ]);

        $v->setAttributeNames([
          'idUnidad'=>'Unidad',
          'idPadre'=>'Plaza funcional',
          'dui'=>'Dui del empleado',
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
       if($request->dui=='' || $request->dui==NULL){return "<ul class='text-warning'><li>El empleado no posee DUI para guardar registro</li></ul>";}
        try {
            $historial = HistorialLaboral::find($request->id);
            $historial->unidad = $request->idUnidad;
            $historial->plaza = $request->idPadre;
            $historial->fechaInicio = $request->fechaInicio;
            $historial->fechaFin = $request->fechaFin;
            $historial->observacion = $request->observacion;
            $historial->usuModificacion = Auth::User()->idUsuario;
            $historial->fechaModificacion = Carbon::now();
            $historial->save();

        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }
        return response()->json(['state' => 'success']);

}
    public function nuevaInfoLaboral(Request $request){

        $v = Validator::make($request->all(),[
            'idUnidad'=>'required',
            'idPadre'=>'required',
            'dui'=>'required',

                ]);

        $v->setAttributeNames([
          'idUnidad'=>'Unidad',
          'idPadre'=>'Plaza funcional',
          'dui'=>'Dui del empleado',
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
       if($request->dui=='' || $request->dui==NULL){return "<ul class='text-warning'><li>El empleado no posee DUI para guardar registro</li></ul>";}
        try {
            $historial = new HistorialLaboral;
            $historial->duiEmpleado = $request->dui;
            $historial->unidad = $request->idUnidad;
            $historial->plaza = $request->idPadre;
            $historial->fechaInicio = $request->fechaInicio;
            $historial->fechaFin = $request->fechaFin;
            $historial->observacion = $request->observacion;
            $historial->usuCreacion = Auth::User()->idUsuario;
            $historial->fechaCreacion = Carbon::now();
            $historial->save();

        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }
        return response()->json(['state' => 'success']);

}
    public function nuevaInfoMedica(Request $request){

        $v = Validator::make($request->all(),[
            'txtGrupo'=>'required'
                ]);

        $v->setAttributeNames([
          'txtGrupo'=>'grupo de sangre'

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
            $infoMedica = new InformacionMedica;
            $infoMedica->duiEmpleado = $request->duiEmpleadoM;
            $infoMedica->alergias = $request->txtMedicaAlergias;
            $infoMedica->tipoSangre = $request->txtGrupo;
            $infoMedica->medicamentoPermanente = $request->txtMedicaMedPerma;
            $infoMedica->usuCreacion = Auth::User()->idUsuario;
            $infoMedica->fechaCreacion = Carbon::now();
            $infoMedica->save();

        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }
        return response()->json(['state' => 'success']);

}
    public function destroyContacto(Request $request){

        $v = Validator::make($request->all(),[
            'txtIdContacto'=>'required'
                ]);

        $v->setAttributeNames([
          'txtIdContacto'=>'id de contacto'

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
            $infoConta = ContactosEmpleados::find($request->txtIdContacto);
            $infoConta->delete();

        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }
        return response()->json(['state' => 'success']);

}
	public function destroyEstudio(Request $request){

			$v = Validator::make($request->all(),[
	        	'txtIdEstudio'=>'required'
				    ]);

	   		$v->setAttributeNames([
	   		  'txtIdEstudio'=>'id de estudio'

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
		    	$infoEstudio = InformacionEstudio::find($request->txtIdEstudio);
		      	$infoEstudio->delete();

			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
	public function downloadPdf($urlDocumento){
      //dd($tipoDocumento);
		$urlDocumento=Crypt::decrypt($urlDocumento);

								if (File::isFile($urlDocumento))
								{

									try {
											    $file = File::get($urlDocumento);
											    $response = Response::make($file, 200);
											    $response->header('Content-Type', 'application/pdf');

											    return $response;
								     } catch (Exception $e) {

										    return Response::download(trim($urlDocumento));
								     }
								}else{
									return back();
								}


	}//cierre del metodo
	public function storeDocumentoExp(Request $request){

			$v = Validator::make($request->all(),[
	        	'fileDocumentoEmple'=>'required',
	        	'duiEmpleado'=>'required',
	        	'idTipoDoc'=>'required',
				    ]);

	   		$v->setAttributeNames([
	        	'fileDocumentoEmple'=>'documento',
	        	'duiEmpleado'=>'dui empleado',
	        	'idTipoDoc'=>'tipo de documento',
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
		    		if($request->idTipoDoc==1){
		    			$nombre='dui';
		    		}else if($request->idTipoDoc==2){
		    			$nombre='nit';
		    		}else if($request->idTipoDoc==3){
		    			$nombre='isss';
		    		}else if($request->idTipoDoc==4){
		    			$nombre='afp';
		    		}
		      		$urlPrincipal = $this->url;
		      	    $path= $urlPrincipal.'\\'.$request->duiEmpleado;
				    $file= $request->file('fileDocumentoEmple');

			if(!empty($file)){
					$filesystem= new Filesystem();
				    if($filesystem->exists($path)){
						    if($filesystem->isWritable($path)){
								$carpeta=$path.'\\'.$nombre;
								File::makeDirectory($carpeta, 0777, true, true);
								$name= date("Y").date("m").date("d").' - '.$file->getClientOriginalName();
								$type = $file->getMimeType();
								$file->move($carpeta,$name);

								$documento = new DocumentosEmpleado();
						    	$documento->duiEmpleado=$request->duiEmpleado;
						    	$documento->idTipo = $request->idTipoDoc;
						    	$documento->estado=1;
						    	$documento->descripcion = $request->descripcion;
						    	$documento->nombreDocumento=$name;
						    	$documento->urlDocumento=$carpeta.'\\'.$name;
						     	$documento->usuarioCreacion = Auth::User()->idUsuario;
						      	$documento->save();

						   }else{
						   		DB::rollback();
								return " Error al subir la fotorafía";
						   }

				    }else{
					  	    $carpeta=$path.'\\'.$nombre;
							File::makeDirectory($carpeta, 0777, true, true);
							$name= date("Y").date("m").date("d").' - '.$file->getClientOriginalName();
							$type = $file->getMimeType();
							$file->move($carpeta,$name);

						    $documento = new DocumentosEmpleado();
					    	$documento->duiEmpleado=$request->duiEmpleado;
					    	$documento->idTipo = $request->idTipoDoc;
					    	$documento->estado=1;
					    	$documento->descripcion = $request->descripcion;
					    	$documento->nombreDocumento=$name;
					    	$documento->urlDocumento=$carpeta.'\\'.$name;
					     	$documento->usuarioCreacion = Auth::User()->idUsuario;
					      	$documento->save();

				  }
				}


			} catch(Exception $e){
			    DB::rollback();
			    throw $e;
			    return $e->getMessage();
			}
			return response()->json(['state' => 'success']);

	}
    public function destroyDocumentoPersonal(Request $request){

        $v = Validator::make($request->all(),[
            'idDocumento'=>'required'
                ]);

        $v->setAttributeNames([
            'idDocumento'=>'id de documento'

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
            $doc = DocumentosEmpleado::find($request->idDocumento);
            $doc->estado=0;
            $doc->usuarioModificacion=Auth::User()->idUsuario;
            $doc->save();
        } catch(Exception $e){
            DB::rollback();
            throw $e;
            return $e->getMessage();
        }
        return response()->json(['state' => 'success']);

}
}
