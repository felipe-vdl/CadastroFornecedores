<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequerimentoInscricao extends Model
{
    protected $table = "documento_requerimentoinscricao";

    public $timestamps = false;

    protected $fillable = [
    'cadastro_id',
    'filename',
    'extensao'
    ];

    public function cadastro()
    
    {
    return $this->belongsTo(Cadastro::class);
    }
}
