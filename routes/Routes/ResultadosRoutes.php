<?php

Route::group(['prefix' => 'evaluaciones' , 'middleware' => ['auth' , 'verifypermissions']], function(){

	Route::group(['prefix' => 'EmpleadosTemporales' , 'middleware' => ['auth' , 'verifypermissions']], function(){

		//Mostrar Resultados de evaluaciones empleados temporales
		Route::get('mostrarTemporales/{idEmpleado}',[
			'as' => 'eval.empleados.temp.mostrar',
			'permissions' => [458,498],
			'uses' => 'ResultadoEvaluacionesController@mostrarTemporales'
	 	]);

	 	//Mostrar Tarea
	 	Route::get('tarea/{idRes}/{idTar}/mostrar',[
				'as' => 'empleado.temp.mostrar.tarea',
				'permissions' => [458,498],
				'uses' => 'ResultadoEvaluacionesController@mostrarTarea'
		]);

	});
});