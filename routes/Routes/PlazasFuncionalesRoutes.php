<?php

Route::group(['prefix' => 'cat' , 'middleware' => ['auth' , 'verifypermissions']], function(){

	Route::group(['prefix' => 'plazaFunc'], function(){

		Route::group(['prefix' => 'funcion'], function(){

			Route::get('/{idFuncion}',[
					'as' => 'funcion.tareas',
					'permissions' => [458],
					'uses' => 'PlazaFuncionalController@detalleFuncion'
			]);

			Route::get('/tarea/detalle/{idTarea}',[
					'as' => 'tarea.detalle',
					'permissions' => [458],
					'uses' => 'PlazaFuncionalController@detalleTarea'
			]);

			//Guardamos la funcion editada
		 	Route::post('/editarFuncion',[
				'as' => 'editar.funcion',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@editarFuncion'
		 	]);

		 	//Guardamos la tarea editada
		 	Route::post('/storeTarea',[
				'as' => 'store.tarea',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeTarea'
		 	]);

		 	//Eliminamos la tarea
		 	Route::get('/eliminarTarea/{idTarea}',[
				'as' => 'eliminar.tarea',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@eliminarTarea'
		 	]);

		 	//Guardamos el Criterio de desempeño editado o nuevo
		 	Route::post('/storeCriterio',[
				'as' => 'store.criterio',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeCriterio'
		 	]);

		 	//Guardamos el Producto editado o nuevo
		 	Route::post('/storeProducto',[
				'as' => 'store.producto',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeProducto'
		 	]);

		 	//Editar Conocimiento
		 	Route::get('/editarConocimiento/{idConocimiento}',[
				'as' => 'editar.conocimiento',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@editarConocimiento'
		 	]);

		 	//Guardamos el Conocimiento editado o nuevo
		 	Route::post('/storeConocimiento',[
				'as' => 'store.conocimiento',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeConocimiento'
		 	]);

		 	//Editar Actitud
		 	Route::get('/editarActitud/{idActitud}',[
				'as' => 'editar.actitud',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@editarActitud'
		 	]);

		 	//Guardamos la Actitud editado o nuevo
		 	Route::post('/storeActitud',[
				'as' => 'store.actitud',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeActitud'
		 	]);

		 	//Eliminamos el Criterio
		 	Route::get('/eliminarDesempenio/{idDesempenio}',[
				'as' => 'eliminar.desempenio',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@eliminarDesempenio'
		 	]);

		 	//Eliminamos el Producto
		 	Route::get('/eliminarProducto/{idProducto}',[
				'as' => 'eliminar.producto',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@eliminarProducto'
		 	]);

		 	//Eliminamos el Conocimiento
		 	Route::get('/eliminarConocimiento/{idConocimiento}',[
				'as' => 'eliminar.conocimiento',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@eliminarConocimiento'
		 	]);

		 	//Eliminamos la Actitud
		 	Route::get('/eliminarActitud/{idActitud}',[
				'as' => 'eliminar.actitud',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@eliminarActitud'
		 	]);

		 	//Guardamos el nuevo Tipo de Conocimiento
		 	Route::post('/storeTipoConocimiento',[
				'as' => 'store.tipoConocimiento',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeTipoConocimiento'
		 	]);

		 	//Guardamos la Funcion
		 	Route::post('/storeFuncion',[
				'as' => 'store.funcion',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@storeFuncion'
		 	]);

		 	//Eliminamos la función
		 	Route::get('/eliminarFuncion/{idFuncion}',[
				'as' => 'eliminar.funcion',
				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@eliminarFuncion'
		 	]);

		 	//selectize de Tipo Conocimiento
		   	Route::get('find/tipoConocimiento',[
 				'as' => 'find.tipoConocimiento',
 				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@findTipoConocimientoSelectize'
			]);

			//selectize de Tipo Actitud
		   	Route::get('find/tipoActitud',[
 				'as' => 'find.tipoActitud',
 				'permissions' => [458],
				'uses' => 'PlazaFuncionalController@findTipoActitudSelectize'
			]);


		     Route::get('generar-pdf/plazaFuncional/{texto}/{idPlazaFuncional}',[
 				'as' => 'generar.pdf.plaza',
 				'permissions' => [458],
				'uses' => 'PdfController@manualPuesto'
			]);
		      Route::get('generar-pdf/matriz/plazaFuncional/{text}/{idPlazaFuncional}',[
 				'as' => 'generar.pdf.plaza.matriz',
 				'permissions' => [458],
				'uses' => 'PdfController@matrizPlazaFun'
			]);
		        Route::get('generar-excel/matriz/plazaFuncional/{idPlazaFuncional}',[
 				'as' => 'generar.excel.plaza.matriz',
 				'permissions' => [458],
				'uses' => 'PdfController@matrizPlazaFunExcel'
			]);




		});

	});
});