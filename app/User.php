<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $table = 'users';

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
