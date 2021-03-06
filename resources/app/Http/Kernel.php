<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'App\Http\Middleware\VerifyCsrfToken',
	];
	
	protected $middlewareGroups = [
	        'web' => [ 
	            \App\Http\Middleware\EncryptCookies::class,
	            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
	            \Illuminate\Session\Middleware\StartSession::class,
	            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
	            \App\Http\Middleware\VerifyCsrfToken::class,
	            \App\Http\Middleware\adminRole::class,
	        ],
	        'api' => [
	            'throttle:60,1',
	        ],
	    ];
	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [		
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'verifypermissions' => 'App\Http\Middleware\VerifyPermissions',	    
	];

}
