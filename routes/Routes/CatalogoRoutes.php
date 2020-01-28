<?php

Route::group(['prefix' => 'cat' , 'middleware' => ['auth' , 'verifypermissions']], function(){


    	Route::group(['prefix' => 'unidad'], function(){
		         Route::get('/',[
					'as' => 'unidad.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexUnidad'
			 	]);

			 	Route::get('/dt-row-data/unidad',[
					'as' => 'dt.row.data.unidad',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsUnidad'
			 	]);
			   Route::get('/nueva',[
					'as' => 'insertar.unidad',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevaUnidad'
			 	]);
			  Route::post('/postUnidad',[
					'as' => 'guardar.unidad',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeUnidad'
			 	]);
			  Route::post('/editarUnidad',[
					'as' => 'post.editar.unidad',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarUnidad'
			 	]);

			   Route::get('/info/unidad',[
					'as' => 'data.unidad',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getUnidad'
			 	]);



		 	});


    	  Route::group(['prefix' => 'tipoEst'], function(){
		         Route::get('/',[
					'as' => 'tipoEst.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexTipoEst'
			 	]);

			 	Route::get('/dt-row-data/tipoEst',[
					'as' => 'dt.row.data.tipoEst',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsTipoEst'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.tipoEst',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevoTipoEst'
			 	]);
			  Route::post('/postTipoEst',[
					'as' => 'guardar.tipoEst',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeTipoEst'
			 	]);
			  Route::post('/editarTipoEst',[
					'as' => 'post.editar.tipoEst',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarTipoEst'
			 	]);

			   Route::get('/info/tipoEst',[
					'as' => 'data.tipoEst',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getTipoEst'
			 	]);
		 	});


    	  Route::group(['prefix' => 'institucion'], function(){
		         Route::get('/',[
					'as' => 'institucion.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexInstitucion'
			 	]);

			 	Route::get('/dt-row-data/institucion',[
					'as' => 'dt.row.data.institucion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsInstitucion'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.institucion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevaInstitucion'
			 	]);
			  Route::post('/postInstitucion',[
					'as' => 'guardar.institucion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeInstitucion'
			 	]);
			  Route::post('/editarInstitucion',[
					'as' => 'post.editar.institucion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarInstitucion'
			 	]);

			   Route::get('/info/institucion',[
					'as' => 'data.institucion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getInstitucion'
			 	]);

			   Route::get('/info/paises',[
					'as' => 'data.paises',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getPaises'
			 	]);



		 	});

    	  Route::group(['prefix' => 'parentesco'], function(){
		         Route::get('/',[
					'as' => 'parentesco.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexParentesco'
			 	]);

			 	Route::get('/dt-row-data/parentesco',[
					'as' => 'dt.row.data.parentesco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsParentesco'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.parentesco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevoParentesco'
			 	]);
			  Route::post('/postParentesco',[
					'as' => 'guardar.parentesco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeParentesco'
			 	]);
			  Route::post('/editarParentesco',[
					'as' => 'post.editar.parentesco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarParentesco'
			 	]);

			   Route::get('/info/parentesco',[
					'as' => 'data.parentesco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getParentesco'
			 	]);
		 	});



    	    Route::group(['prefix' => 'grupoSang'], function(){
		         Route::get('/',[
					'as' => 'grupoSang.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexGrupoSang'
			 	]);

			 	Route::get('/dt-row-data/grupoSang',[
					'as' => 'dt.row.data.grupoSang',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsGrupoSang'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.grupoSang',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevoGrupoSang'
			 	]);
			  Route::post('/postGrupoSang',[
					'as' => 'guardar.grupoSang',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeGrupoSang'
			 	]);
			  Route::post('/editarGrupoSang',[
					'as' => 'post.editar.grupoSang',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarGrupoSang'
			 	]);

			   Route::get('/info/grupoSang',[
					'as' => 'data.grupoSang',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getGrupoSang'
			 	]);
		 	});



		 	 Route::group(['prefix' => 'motivos'], function(){
		         Route::get('/',[
					'as' => 'motivos.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexMotivos'
			 	]);

			 	Route::get('/dt-row-data/motivos',[
					'as' => 'dt.row.data.motivos',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsMotivo'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.motivos',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevoMotivo'
			 	]);
			  Route::post('/postMotivos',[
					'as' => 'guardar.motivos',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeMotivo'
			 	]);
			  Route::post('/editarMotivos',[
					'as' => 'post.editar.motivos',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarMotivo'
			 	]);

			   Route::get('/info/motivos',[
					'as' => 'data.motivos',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getMotivo'
			 	]);
		 	});


		 	 Route::group(['prefix' => 'plazaFunc'], function(){
		         Route::get('/',[
					'as' => 'plazaFunc.listar',
					'permissions' => [458],
					'uses' => 'CatalogoController@indexPlazaFunc'
			 	]);

			 	Route::get('/dt-row-data/plazaFunc',[
					'as' => 'dt.row.data.plazaFunc',
					'permissions' => [458],
					'uses' => 'CatalogoController@getDataRowsPlazaFunc'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.plazaFunc',
					'permissions' => [458],
					'uses' => 'CatalogoController@nuevaPlazaFunc'
			 	]);
			  Route::post('/postPlazaFunc',[
					'as' => 'guardar.plazaFunc',
					'permissions' => [458],
					'uses' => 'CatalogoController@storePlazaFunc'
			 	]);

			   Route::get('/editar/plaza/funcional/{idPlaza}',[
					'as' => 'plazaFunc.editar',
					'permissions' => [458],
					'uses' => 'CatalogoController@editarPlazaFuncIndex'
			 	]);
			  Route::post('/editarPlazaFunc',[
					'as' => 'post.editar.plazaFunc',
					'permissions' => [458],
					'uses' => 'CatalogoController@editarPlazaFunc'
			 	]);

			   Route::get('/info/plazaFunc',[
					'as' => 'data.plazaFunc',
					'permissions' => [458],
					'uses' => 'CatalogoController@getPlazaFunc'
			 	]);

			   Route::get('/info/unidades',[
					'as' => 'data.unidades',
					'permissions' => [458],
					'uses' => 'CatalogoController@getUnidades'
			 	]);
			   Route::get('/info/plazaNom/listar',[
					'as' => 'data.plazaNom.listar',
					'permissions' => [458],
					'uses' => 'CatalogoController@getPlazasNom'
			 	]);
			     Route::get('/info/plazaFunListar',[
					'as' => 'data.plazaFunListar',
					'permissions' => [458],
					'uses' => 'CatalogoController@getPlazasListar'
			 	]);

			   //selectize de empleado
			   Route::get('find/empleado',[
	 			'as' => 'find.empleado',
	 			'permissions' => [458],
				'uses' => 'CatalogoController@findEmpleadoSelectize'
 				]);

			   //selectize de plaza funcional
			   Route::get('find/plazaFunc',[
	 			'as' => 'find.plazaFunc',
	 			'permissions' => [458],
				'uses' => 'CatalogoController@findPlazaFunSelectize'
 				]);

			   //selectize de plaza nominal
			   Route::get('find/plazaNom',[
	 			'as' => 'find.plazaNom',
	 			'permissions' => [458],
				'uses' => 'CatalogoController@findPlazaNomSelectize'
 				]);

			   /*Rutas para ver detalle de la plaza funcional*/
			   Route::get('/detalle/{idPlaza}',[
					'as' => 'plazaFunc.detalle',
					'permissions' => [458],
					'uses' => 'PlazaFuncionalController@detallePlazaFunc'
			 	]);

			   /*Terminan Rutas de detalle*/

		 	});


		 	 Route::group(['prefix' => 'plazaNom'], function(){
		         Route::get('/',[
					'as' => 'plazaNom.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexPlazaNom'
			 	]);

			 	Route::get('/dt-row-data/plazaNom',[
					'as' => 'dt.row.data.plazaNom',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsPlazaNom'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.plazaNom',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevaPlazaNom'
			 	]);
			  Route::post('/postPlazaNom',[
					'as' => 'guardar.plazaNom',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storePlazaNom'
			 	]);
			  Route::post('/editarPlazaNom',[
					'as' => 'post.editar.plazaNom',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarPlazaNom'
			 	]);

			   Route::get('/info/plazaNom',[
					'as' => 'data.plazaNom',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getPlazaNom'
			 	]);
		 	});

		 	 	 	 Route::group(['prefix' => 'banco'], function(){
		         Route::get('/',[
					'as' => 'banco.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexBanco'
			 	]);

			 	Route::get('/dt-row-data/banco',[
					'as' => 'dt.row.data.banco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsBanco'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.banco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevoBanco'
			 	]);
			  Route::post('/postBanco',[
					'as' => 'guardar.banco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeBanco'
			 	]);
			  Route::post('/editarBanco',[
					'as' => 'post.editar.banco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarBanco'
			 	]);

			   Route::get('/info/banco',[
					'as' => 'data.banco',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getBanco'
			 	]);
		 	});



		 	  Route::group(['prefix' => 'tipoActitud'], function(){
		         Route::get('/',[
					'as' => 'tipoActitud.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexTipoActitud'
			 	]);

			 	Route::get('/dt-row-data/tipoActitud',[
					'as' => 'dt.row.data.tipoActitud',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsTipoActitud'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.tipoActitud',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevoTipoActitud'
			 	]);
			  Route::post('/postTipoActitud',[
					'as' => 'guardar.tipoActitud',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeTipoActitud'
			 	]);
			  Route::post('/editarTipoActitud',[
					'as' => 'post.editar.tipoActitud',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarTipoActitud'
			 	]);

			   Route::get('/info/tipoActitud',[
					'as' => 'data.tipoActitud',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getTipoActitud'
			 	]);
		 	});

		Route::group(['prefix' => 'estadoLaboral'], function(){
		 	 	Route::get('/',[
		 	 		'as' => 'estadoLaboral.listar',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@indexEstadoLaboral'
		 	 		]);

		 	 	Route::get('/dt-row-data/estadoLaboral',[
		 	 		'as' => 'dt.row.data.estadoLaboral',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@getDataRowsEstadoLaboral'
		 	 		]);
		 	 	Route::get('/nueva',[
		 	 		'as' => 'insertar.estadoLaboral',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@nuevaEstadoLaboral'
		 	 		]);
		 	 	Route::post('/postEstadoLaboral',[
		 	 		'as' => 'guardar.estadoLaboral',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@storeEstadoLaboral'
		 	 		]);
		 	 	Route::post('/eliminarEstadoLaboral',[
		 	 		'as' => 'post.eliminar.estadoLaboral',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@deleteEstadoLaboral'
		 	 		]);
		 	 	Route::post('/editarEstadoLaboral',[
		 	 		'as' => 'post.editar.estadoLaboral',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@editarEstadoLaboral'
		 	 		]);

		 	 	Route::get('/info/estadoLaboral',[
		 	 		'as' => 'data.estadoLaboral',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@getEstadoLaboral'
		 	 		]);

		 	 });

		 	 Route::group(['prefix' => 'clasificacionEmpleado'], function(){
		 	 	Route::get('/',[
		 	 		'as' => 'clasificacionEmpleado.listar',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@indexClasificacionEmpleado'
		 	 		]);

		 	 	Route::get('/dt-row-data/clasificacionEmpleado',[
		 	 		'as' => 'dt.row.data.clasificacionEmpleado',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@getDataRowsClasificacionEmpleado'
		 	 		]);
		 	 	Route::get('/nueva',[
		 	 		'as' => 'insertar.clasificacionEmpleado',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@nuevaClasificacionEmpleado'
		 	 		]);
		 	 	Route::post('/postUnidad',[
		 	 		'as' => 'guardar.clasificacionEmpleado',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@storeClasificacionEmpleado'
		 	 		]);
		 	 	Route::post('/editarClasificacionEmpleado',[
		 	 		'as' => 'post.editar.clasificacionEmpleado',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@editarClasificacionEmpleado'
		 	 		]);
		 	 	Route::post('/eliminarClasificacionEmpleado',[
		 	 		'as' => 'post.eliminar.clasificacionEmpleado',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@deleteClasificacionEmpleado'
		 	 		]);
		 	 	Route::get('/info/clasificacionEmpleado',[
		 	 		'as' => 'data.clasificacionEmpleado',
		 	 		'permissions' => [458,498],
		 	 		'uses' => 'CatalogoController@getClasificacionEmpleado'
		 	 		]);
		 	 });
});


		 	 Route::group(['prefix' => 'evaluacion', 'middleware' => ['auth' , 'verifypermissions']], function(){
		         Route::get('/',[
					'as' => 'evaluacion.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexEvaluacion'
			 	]);

			 	Route::get('/dt-row-data/evaluacion',[
					'as' => 'dt.row.data.evaluacion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsEvaluacion'
			 	]);
			   Route::get('/nuevo',[
					'as' => 'insertar.evaluacion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevaEvaluacion'
			 	]);
			  Route::post('/postEvaluacion',[
					'as' => 'guardar.evaluacion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeEvaluacion'
			 	]);
			  Route::post('/editarEvaluacion',[
					'as' => 'post.editar.evaluacion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@editarEvaluacion'
			 	]);

			   Route::get('/info/evaluacion',[
					'as' => 'data.evaluacion',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getEvaluacion'
			 	]);

			 	//Rutas para Evaluaciones de Personal Temporal
			 	Route::get('/PersonalTemporal',[
					'as' => 'evaluacionPersonalTemp.listar',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@indexEvaluacionPersonalTemporal'
			 	]);

			 	//Nueva evaluación temporal
			 	Route::get('/nuevoTemporal',[
					'as' => 'insertar.evaluacionTemporal',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@nuevaEvaluacionTemporal'
			 	]);

			 	//Guardamos la evaluacion temporal
			 	Route::post('/postEvaluacionTemporal',[
					'as' => 'guardar.evaluacionTemporal',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@storeEvaluacionTemporal'
			 	]);

			 	//Datatable de evaluaciones Temporales
			 	Route::get('/dt-row-data/evaluacionTemp',[
					'as' => 'dt.row.data.evaluacionTemp',
					'permissions' => [458,498],
					'uses' => 'CatalogoController@getDataRowsEvaluacionTemporal'
			 	]);

		 	});

		 	 