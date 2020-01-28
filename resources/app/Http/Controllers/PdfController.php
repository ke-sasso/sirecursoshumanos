<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use App\PlazasFuncionales;
use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Exception;
use Excel;
class PdfController extends Controller
{

    public function manualPuesto($text,$idPlaza){
    	   $idPlaza =Crypt::decrypt($idPlaza);
    	   $plaza = PlazasFuncionales::find($idPlaza);
    	   $data['plaza'] = $plaza;
         $data['texto'] = $text;
    	   $view =  \View::make('pdf.plazasfuncionales.estandaresCompetencia',$data)->render();

           $pdf = \App::make('dompdf.wrapper');
           $pdf->loadHTML($view);
    	   return $pdf->stream($plaza->nombrePlaza.'.pdf');
    }
     public function matrizPlazaFun($texto,$idPlaza){

    	   $idPlaza =Crypt::decrypt($idPlaza);
    	   $plaza = PlazasFuncionales::find($idPlaza);
    	   $data['plaza'] = $plaza;
         $data['texto'] = $texto;
    	   /* $view =  \View::make('pdf.plazasfuncionales.estandaresCompetencia',$data)->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view);*/

          $pdf = new Dompdf();
          $pdf->set_paper ('A4','landscape');
          $view = \View::make('pdf.plazasfuncionales.matriz',$data);
          $pdf->loadHtml($view);
          $pdf->render();
    	    return $pdf->stream($plaza->nombrePlaza.'.pdf',array('Attachment'=>0));
    }

      public function matrizPlazaFunExcel($idPlaza){


         $file = Excel::create('MATRIZ', function($excel) use ($idPlaza) {
         $excel->sheet('FUNCIONES - TAREAS', function($sheet) use ($idPlaza) {
          //$rowNumber = 1;
          $sheet->appendRow([
                'FUNCIÓN','LITERAL','NUMERO','TAREA']);

         $idPlaza =Crypt::decrypt($idPlaza);
         $plaza = PlazasFuncionales::find($idPlaza);
        if(!empty($plaza->funciones)){
            foreach($plaza->funciones->where('activo',1)->sortBy('literal')  as $funcion){
                if(!empty($funcion->tareas->where('activo',1))){

                    foreach($funcion->tareas->where('activo',1)->sortBy('numero') as $tarea){
                      $sheet->appendRow([
                      $funcion->nombreFuncion,$funcion->literal,$tarea->numero,$tarea->nombreTarea
                     ]);

                    }
                }
            }
        }
          //$sheet->mergeCells('A'.$rowIni.':A'.$rowNumber);
          $sheet->setAutoFilter();
          });
        })->export('xlsx');

    }

}
