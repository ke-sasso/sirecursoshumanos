<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption;
use App\Models\rrhh\VwAllPermisos;
use App\Models\rrhh\rh\Bancos;
use DB;
use Auth;
use File;
use Crypt;
use Validator;
use Yajra\Datatables\Datatables;
use App\Unidades;
use App\CatEmpleados;
use App\Models\rrhh\rh\GrupoSanguineo;
use App\Models\rrhh\rh\Empleados;
use App\Models\rrhh\rh\Funciones;
use App\Models\rrhh\rh\Tareas;
use App\Models\rrhh\rh\TareasActitudes;
use App\Models\rrhh\rh\TareasConocimientos;
use App\Models\rrhh\rh\TareasDesempenios;
use App\Models\rrhh\rh\TareasProductos;
use App\Models\rrhh\rh\Departamentos;
use App\Models\rrhh\rh\Municipios;
use App\Models\rrhh\rh\ContactosEmpleados;
use App\Models\rrhh\rh\InformacionEstudio;
use App\Models\rrhh\rh\InformacionMedica;
use App\Models\rrhh\rh\InformacionSanciones;
use App\Models\rrhh\edc\Evaluaciones;
use App\PlazasFuncionales;
use App\PlazasNominales;
use App\pdf\PdfEvaluacion;
use App\Models\rrhh\edc\resultados\Resultados;
use App\Models\rrhh\edc\resultados\Tareas as ResultadosTar;
use App\Models\rrhh\edc\resultados\CompetenciasEstados;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EvaluacionesController extends Controller {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
	}


	public function getEvaluaciones(){

    $data = ['title' 			=> 'Evaluaciones'
				,'subtitle'			=> '>EMPLEADOS'
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Evaluaciones', 'url' => '#'],
			 		['nom'	=>	'Recursos Humanos', 'url' => '#']
				]];
		return view('edc.evaluacion.evaluaciones',$data);
	}


public function  getDataRowsEvaluaciones(Request $request){
		$evaluaciones=Evaluaciones::getEvaluaciones();

        if(empty($request->get('fechaInicio')) && empty($request->get('fechaFin'))){
        	  return Datatables::of($evaluaciones)
		          ->addColumn('descripcion', function($dt){
                        if($dt->descripcion==null){

                              return "--";
                        }else{
                        	return $dt->descripcion;
                        }


		          })
			   ->addColumn('detalle', function ($dt) {

	              return	'<a href="'.route('ver.evaluaciones.empleados',['idEvaluacion' =>Crypt::encrypt($dt->idEvaluacion)]).'" class="btn btn-xs btn-success btn-perspective" ><i class="fa fa-users"></i></a>';


					})
			   ->make(true);
        }else{

        return Datatables::of($evaluaciones)
		          ->addColumn('descripcion', function($dt){
                        if($dt->descripcion==null){

                              return "--";
                        }else{
                        	return $dt->descripcion;
                        }


		          })
			   ->addColumn('detalle', function ($dt) {

	              return	'<a href="'.route('ver.evaluaciones.empleados',['idEvaluacion' =>Crypt::encrypt($dt->idEvaluacion)]).'" class="btn btn-xs btn-success btn-perspective" ><i class="fa fa-users"></i></a>';


					})
			   ->filter(function($query) use ($request){


	        				if($request->has('fechaInicio') and $request->has('fechaFin')){
	        					$query->whereBetween(DB::raw('Convert(varchar(10), fechaInicio,120)'),[date('Y-m-d',strtotime(str_replace("/","-",$request->get('fechaInicio')))),date('Y-m-d',strtotime(str_replace("/","-",$request->get('fechaFin'))))]);
	        				}
	        				elseif($request->has('fechaInicio')){
	        					$query->where(DB::raw('Convert(varchar(10), fechaInicio,120)'),'=',date('Y-m-d',strtotime(str_replace("/","-",$request->get('fechaInicio')))));
	        				}
	        				elseif($request->has('fechaFin')){
	        					$query->where(DB::raw('Convert(varchar(10), fechaFin,120)'),'=',date('Y-m-d',strtotime(str_replace("/","-",$request->get('fechaFin')))));
	        				}

	        			})

			->make(true);
		}


	}

      public function   getDataRowsEmpleados($idEvaluacion,Request $request){
	//	dd($idEvaluacion);
		/*HACER LA CONSULTA PARA MOSTRAR*/
		$idEvaluacion=Crypt::decrypt($idEvaluacion);
		$evaEmpleados=Evaluaciones::getEmpleadosEvaluaciones($idEvaluacion,$request);
      //dd($evaEmpleados);
		for ($i=0;  $i < count($evaEmpleados); $i++) {

			if($evaEmpleados[$i]->idPlazaFuncional!=$evaEmpleados[$i]->plazaFuncional){
				$evaEmpleados->pull($i);
			}

		}
		return Datatables::of($evaEmpleados)
         		   ->addColumn('finalizada',function($dt){
         		   		if($dt->finalizada == 1)
         		   		{
         		   			return '<i class="fa fa-check" aria-hidden="true"></i>';
         		   		}
         		   		return '';
         		   })
				   ->addColumn('CP', function ($dt) {
				   	  if($dt->CP == null){

				       return '<span  class="label label-danger">0.00</span>';
				   	  }else{

					  	return '<span  class="label label-info">'.$dt->CP.'</span>';
				        }

					})

			   ->addColumn('detalle', function ($dt) use ($idEvaluacion){
				            	//if($dt->dui != ''){
			   	if($dt->finalizada==1){
				   	if($dt->CP != null){
					    return	'<a href="'.route('edc.empleado.vistaprevia',['idEvaluacion'=>Crypt::encrypt($idEvaluacion),'idEmpleado' =>Crypt::encrypt($dt->idEmpleado)]).'" class="btn btn-xs btn-success btn-perspective" target="_blank" ><i class="fa fa-file-text-o"></i></a>';
					}
				}
			//	}else{
			//		return '<span class="label label-danger">El empleado no se puede consultar</span>';
			//	}

					})
			      ->addColumn('fechaEvaluacion', function ($dt) {

				     if($dt->fechaEvaluacion == null){

				       return '----';
				   	  }else{

					  	return $dt->fechaEvaluacion;
				        }



					})

			->make(true);

	}

    public function mostrarEvaluacionesEmpleados($idEvaluacion){

   		 $data = ['title' 			=> 'Empleados evaluaciones'
				,'subtitle'			=> ''
				,'idEvaluacion'     => $idEvaluacion
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Evaluaciones', 'url' => route('evaluacion.listar')],
			 		['nom'	=>	'Evaluaciones empleados', 'url' => '#']
				]];

        //$idEvaluacion = ['idEvaluacion'=>$idEvaluacion];
        $data['unidades']=Unidades::all();

		return view('edc.evaluacion.evaluacionesEmpleados',$data);

	}

	public function mostrarEvaluacionesEmpleadosTemporales($idEvaluacion){

   		 $data = ['title' 			=> 'Empleados Temporales Evaluaciones'
				,'subtitle'			=> ''
				,'idEvaluacion'     => $idEvaluacion
				,'breadcrumb' 		=> [
			 		['nom'	=>	'Evaluaciones', 'url' => route('evaluacionPersonalTemp.listar')],
			 		['nom'	=>	'Evaluaciones Empleados Temporales', 'url' => '#']
				]];

        $data['unidades']=Unidades::all();

		return view('edc.evaluacion.evaluacionesEmpleadosTemporales',$data);

	}

	public function getDataRowsEmpleadosTemporales(Request $request){

		$emp = Empleados::getEmpleadosTemporales();

		return Datatables::of($emp)
        	->addColumn('evaluacion', function ($dt) {
            	return '<a href="'.route('eval.empleados.temp.mostrar',['idEmpleado' => Crypt::encrypt($dt->idEmpleado)]).'" class="btn btn-xs btn-info btn-perspective"><i class="fa fa-eye"></i> Mostrar</a>';
            })
            ->make(true);

	}

	public function vistaPrevia(Request $request,$idEva,$idEmp){

		$idEva=Crypt::decrypt($idEva);
		$idEmp=Crypt::decrypt($idEmp);

		$pdf = new PdfEvaluacion();
		$pdf->SetAuthor('Dirección Nacional de Medicamentos');
		$pdf->SetTitle('Evaluacion de Desempeño');
		$pdf->SetSubject('Evaluacion');
		$pdf->SetKeywords('DNM, PDF, Evaluacion');
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
		$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(true);

		$pdf->AddPage('P');

		$emp = Empleados::findOrFail($idEmp);
		$eva = Evaluaciones::findOrFail($idEva);
		/*$resultado = AdministradorController::findOrCreateResultado($eva,$emp,Auth::user()->idUsuario.'@'.$request->ip());*/
		$jefe = plazasFuncionales::findOrFail($emp->plazaFuncional->idPlazaFuncionalPadre);
		//$estados = CompetenciasEstados::getDataEstados();

		$pdf->SetFont('Times','',8);

		if($emp->plazaFuncional->unidad->tipoUnidad==1){
			$area = 'Administrativa';
		}else{
			$area = 'Técnica';
		}

		$resultado = Resultados::where('idEvaluacion',$idEva)->where('idEmpleado',$idEmp)->first();
//dd($emp->plazaFuncional->idPlazaFuncional);
		$tabla = '<table border="1">
				<tbody>
				<tr align="left" >
					<td  style="width: 535px"><strong> Nombre: </strong>'.$emp->nombresEmpleado.' '.$emp->apellidosEmpleado.'</td>
					<td  style="width: 110px"><strong> Codigo: </strong>'.$emp->idEmpleado.'</td>
				</tr>
				<tr align="left" >
					<td  style="width: 425px"><strong> Nombre del Puesto: </strong>'.$resultado->plazaFuncional->nombrePlaza.'</td>
					<td  style="width: 110px"><strong> Área: </strong>'.$area.'</td>
					<td  style="width: 110px"><strong> Salario: </strong>$</td>
				</tr>
				<tr align="left" >
					<td  style="width: 645px"><strong> Subordinación: </strong>'.$jefe->nombrePlaza.'</td>
				</tr>
				<tr align="left" >
					<td  style="width: 210px"><strong> Fecha Ingreso: </strong></td>
					<td  style="width: 225px"><strong> Período a Evaluar: </strong>'.$eva->periodo.'</td>
					<td  style="width: 210px"><strong> Fecha de Evaluacion: </strong>'.$resultado->fechaEvaluacion.' </td>

				</tr>
				<tr align="left">
					<td style="width: 645px"></td>
				</tr>

			</tbody></table>';
		$pdf->writeHTML($tabla, true, false, true, false, '');

		$x = $pdf->GetX();
		$y = $pdf->GetY();

		$pdf->SetXY($x, $y);

		$tabla = '<table border="1">
				<tbody>';

		foreach($resultado->funciones()->orderBy('literal','asc')->get() as $f){
			$tareas = $f->tareas()->orderBy('numero','asc')->get();
			for ($i=0; $i < count($tareas) ; $i++) {
				$tabla.= '<tr nobr="true">
					<td style="width: 350px"><strong>FUNCIÓN: </strong>'.$f->literal.'. '.$f->nombreFuncion.'</td>
					<td style="width: 295px"><strong>TAREA </strong>['.$tareas[$i]->numero.' de '.count($tareas).']: '.$f->literal.'.'.$tareas[$i]->numero.' '.$tareas[$i]->nombreTarea.'</td>
					</tr>
					<tr align="left" nobr="true">
						<td style="width: 645px"></td>
					</tr>
					<tr align="Center" nobr="true">
						<td style="width: 645px"><strong>Desempeño</strong></td>
					</tr>
					<tr align="Center" nobr="true">
						<td style="width: 400px;height:35px;"><strong>Criterios de desempeño</strong></td>
						<td style="width: 120px;height:35px;"><strong>Nivel de Competencia</strong></td>
						<td style="width: 125px;height:35px;"><strong>Accion a tomar</strong></td>
					</tr>';

				$reTar = ResultadosTar::where('idResultado',$resultado->idResultado)->where('idTarea',$tareas[$i]->idTarea)->first();

				foreach ($reTar->desempenios()->orderBy('numero','asc')->get() as $dese) {

					if($dese->idEstado!=null ||$dese->idEstado!=''){
						$estado = CompetenciasEstados::where('idEstado',$dese->idEstado)->select('nombreEstado')->first();
						$estado = $estado->nombreEstado;
					}else{$estado = ''; }

					$tabla.= '
					<tr nobr="true">
							<td style="width: 400px"> '.$dese->numero.' '.$dese->nombreDesempenio.'</td>
							<td style="width: 120px;text-align:center">'.$estado.'</td>
							<td style="width: 125px">'.$dese->accionTomar.'</td>
					</tr>';
				}

			$tabla .= '<tr align="left" nobr="true">
						<td style="width: 645px"></td>
					</tr>
					<tr align="Center" nobr="true">
						<td style="width: 645px"><strong>Productos</strong></td>
						</tr>
					<tr align="Center" nobr="true">
						<td style="width: 400px;height:35px;"><strong>Productos</strong></td>
						<td style="width: 120px;height:35px;"><strong>Verificacion de evidencia</strong></td>
						<td style="width: 125px;height:35px;"><strong>Accion a tomar</strong></td>
					</tr>';
				foreach ($reTar->productos()->orderBy('numero','asc')->get() as $prod) {

					if($prod->idEstado!=null ||$prod->idEstado!=''){
						$estado = CompetenciasEstados::where('idEstado',$prod->idEstado)->select('nombreEstado')->first();
						$estado = $estado->nombreEstado;
					}else{$estado = ''; }
					$tabla.= '
					<tr nobr="true">
							<td style="width: 400px"> '.$prod->numero.' '.$prod->nombreProducto.'</td>
							<td style="width: 120px;text-align:center">'.$estado.'</td>
							<td style="width: 125px">'.$prod->accionTomar.'</td>
					</tr>';
				}

			$tabla .= '<tr align="left" nobr="true">
						<td style="width: 645px"></td>
					</tr>
					<tr align="Center" nobr="true">
						<td style="width: 645px"><strong>Conocimientos</strong></td>
						</tr>
					<tr align="Center" nobr="true">
						<td style="width: 300px;height:35px;"><strong>Conocimientos</strong></td>
						<td style="width: 100px;height:35px;"><strong>Nivel</strong></td>
						<td style="width: 120px;height:35px;"><strong>Nivel de Competencia</strong></td>
						<td style="width: 125px;height:35px;"><strong>Accion a tomar</strong></td>
					</tr>';

			foreach ($reTar->conocimientos()->orderBy('numero','asc')->get() as $cono) {

				if($cono->idEstado!=null ||$cono->idEstado!=''){
						$estado = CompetenciasEstados::where('idEstado',$cono->idEstado)->select('nombreEstado')->first();
						$estado = $estado->nombreEstado;
					}else{$estado = ''; }
					$tabla.= '
					<tr nobr="true">
							<td style="width: 300px"> '.$cono->numero.' '.$cono->nombreConocimiento.'</td>
							<td style="width: 100px"> '.$cono->nombreNivel.'</td>
							<td style="width: 120px;text-align:center"> '.$estado.'</td>
							<td style="width: 125px"> '.$cono->accionTomar.'</td>
					</tr>';
			}

			$tabla .= '<tr align="left" nobr="true">
						<td style="width: 645px"></td>
					</tr>
					<tr align="Center" nobr="true">
						<td style="width: 645px"><strong>Actitudes</strong></td>
						</tr>
					<tr align="Center" nobr="true">
						<td style="width: 400px;height:35px;"><strong>Actitudes</strong></td>
						<td style="width: 120px;height:35px;"><strong>Nivel de Competencia</strong></td>
						<td style="width: 125px;height:35px;"><strong>Accion a tomar</strong></td>
					</tr>';

			foreach ($reTar->actitudes()->orderBy('numero','asc')->get() as $acti) {

				if($acti->idEstado!=null ||$acti->idEstado!=''){
					$estado = CompetenciasEstados::where('idEstado',$acti->idEstado)->select('nombreEstado')->first();
					$estado = $estado->nombreEstado;
				}else{$estado = ''; }

				$tabla.= '
				<tr nobr="true">
						<td style="width: 400px"> '.$acti->numero.' '.$acti->nombreActitud.'</td>
						<td style="width: 120px;text-align:center">'.$estado.'</td>
						<td style="width: 125px">'.$acti->accionTomar.'</td>
				</tr>';
			}

			$tabla .='<tr align="left" nobr="true">
						<td style="width: 645px"></td>
					</tr>
					<tr align="center" nobr="true">
						<td style="width: 645px;" height="35px"><strong>RESULTADO CT: '.$tareas[$i]->CT.'%'.'</strong></td>
					</tr>
					<tr align="left" nobr="true">
						<td style="width: 645px"></td>
					</tr>';

			}

		}

		$tabla .='<tr align="center" nobr="true">
					<td style="width: 645px;" height="35px"><strong>RESUMEN DE RESULTADO OBTENIDO<br>CP: '.$resultado->CP.'%&nbsp;&nbsp;&nbsp;&nbsp;RESULTADO: '.$resultado->estado->nombreEstado.'</strong></td>
				</tr>
				</tbody></table>';

		$pdf->writeHTML($tabla, true, false, true, false, '');

		$x = $pdf->GetX();
		$y = $pdf->GetY();

		$pdf->SetXY($x, $y);

		$tabla = '<table border="1">
				<tbody>
					<tr nobr="true">
						<td style="width: 450px;height:75px;"><strong>Nombre del jefe que evalúa:</strong></td>
						<td style="width: 195px;height:75px;" align="center"><strong>Firma y sello de quien evalúa</strong></td>
					</tr>
					<tr nobr="true">
						<td style="width: 450px;height:100px;"><strong>Comentarios de la persona evaluada:</strong></td>
						<td style="width: 195px;height:100px;" align="center"><strong>Firma de la persona evaluada</strong></td>
					</tr>
				</tbody></table>';

		$pdf->writeHTML($tabla, true, false, true, false, '');

		$pdf->Output('Evaluacion.pdf');
		//return "llega al controlador";

	}


}