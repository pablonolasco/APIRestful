<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const USUARIO_VERIFICADO='1';
    const USUARIO_NO_VERIFICADO='0';

    const USUARIO_ADMINISTRADOR='true';
    const USUARIO_REGULAR='false';

    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'verified',
        'verification_token',
        'admin'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * @return bool validad si el usuario es el administrador
     */
    public function esAdmin(){
        return $this->admin==User::USUARIO_ADMINISTRADOR;
    }

    /**
     * @return bool valida si el usuario si se ha verificado el usuario
     */
    public function esVerificado(){
        return $this->verified==User::USUARIO_VERIFICADO;
    }

    /**
     * @return string retorna el token
     */
    public static function generarVerificationToken(){
        return str_random(40);
    }


}
