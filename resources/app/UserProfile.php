<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'dnm_catalogos.sys_perfiles_usuarios';
	protected $primaryKey = 'idPerfil';
	protected $timestap = false;

	public function getRolUsuario()
	{
		return $this->hasMany('App\UserOptions','idPerfil','idPerfil');
	}
}
