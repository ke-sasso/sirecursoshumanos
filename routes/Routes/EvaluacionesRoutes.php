<?php

Route::group(['prefix' => 'evaluaciones' , 'middleware' => ['auth' , 'verifypermissions']], function(){



             Route::get('/',[
		 		'as' => 'all.evaluaciones',
				'permissions' => [458,498],
				'uses' => 'EvaluacionesController@getEvaluaciones'
		 	]);	

           Route::get('/dt-row-data-evaluaciones',[
	 		'as' => 'dt.row.data.evaluaciones',
			'permissions' => [458,498],
			'uses' => 'EvaluacionesController@getDataRowsEvaluaciones'
	 	]);

         Route::get('/mostrarEmpleados/{idEvaluacion}',[
			'as' => 'ver.evaluaciones.empleados',
			'permissions' => [458,498],
			'uses' => 'EvaluacionesController@mostrarEvaluacionesEmpleados'
	 	]);

      	//Mostrar Empleados de Evaluaciones Temporales
         Route::get('/mostrarEmpleadosTemporales/{idEvaluacion}',[
			'as' => 'ver.evaluaciones.empleados.temporales',
			'permissions' => [458,498],
			'uses' => 'EvaluacionesController@mostrarEvaluacionesEmpleadosTemporales'
	 	]);


       Route::get('/dt-row-data-evaluacionesEmpleados/{idEvaluacion}',[
	 		'as' => 'dt.row.data.evaluacionesEmpleados',
			'permissions' => [458,498],
			'uses' => 'EvaluacionesController@getDataRowsEmpleados'
	 	]);


	 	//Datatable de Empleados Temporales
	 	Route::get('/dt-row-data-evalEmpleadosTemp/',[
	 		'as' => 'dt.row.data.evalEmpleadosTemp',
			'permissions' => [458,498],
			'uses' => 'EvaluacionesController@getDataRowsEmpleadosTemporales'
	 	]);

	 	Route::get('vistaprevia/{idEva}/{idEmp}',[
			'as' => 'edc.empleado.vistaprevia',
			'permissions' => [458,498],
			'uses' => 'EvaluacionesController@vistaPrevia'
	 	]);

});