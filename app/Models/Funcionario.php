<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Funcionario extends Authenticatable
{
    protected $connection = "mysql2";

     protected $fillable = [
        'name', 'email', 'password', 'nivel',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember-token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /* public function cadastros()
    {
    return $this->hasMany(Cadastro::class);
    } */
}
