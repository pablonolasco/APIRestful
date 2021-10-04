<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;// se indica que se va colocar el sofdelete
    const USUARIO_VERIFICADO='1';
    const USUARIO_NO_VERIFICADO='0';

    const USUARIO_ADMINISTRADOR='true';
    const USUARIO_REGULAR='false';

    public $transformer= UserTransformer::class;
    protected $table='users';
    protected $dates=['deleted_at'];// este campo sera tratato como una fecha
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
     * @param $valor
     * un mutador se utiliza para modificar el dato antes de insertarse en la base de datos
     * antes de insertar el dato lo hace en minuscula
     */
    public function setNameAttribute($valor)
    {
        $this->attributes['name'] =strtolower($valor);
    }

    /**
     * @param $valor
     * @return string el valor de la primera letra de cada palabra en mayuscula
     * un accesor se utiliza para modificar el valor despues de obtenerlo de la base de datos
     */
    public function getNameAttribute($valor)
    {
        return ucwords($valor);
    }

    public function setEmailAttribute($valor)
    {
        $this->attributes['email']=strtolower($valor);
    }

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
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    /**
     * @return string retorna el token
     */
    public static function generarVerificationToken(){
        return str_random(40);
    }


}
