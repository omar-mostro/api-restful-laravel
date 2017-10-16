<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $fillable = [

        'name',
        'email',
        'password',
        'verified',
        'verfication_token',
        'admin'
    ];

    protected $hidden = [

        'password',
        'remember_token',
        'verfication_token'
    ];

    public function setNameAttribute($valor)
    {

        $this->attributes['name'] = strtolower($valor);
    }

    public function getNameAttribute($valor){

        return ucwords($valor);
    }

    public function setEmailAttribute($email){

        $this->attributes['email'] = strtolower($email);
    }

    public function esVerificado()
    {
        $this->verified = User::USUARIO_VERIFICADO;
    }

    public function esAdminstrador()
    {
        $this->admin = User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificationToken()
    {
        return str_random(40);
    }
}
