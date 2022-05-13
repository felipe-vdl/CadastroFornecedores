<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocDebitoTrabalhista extends Model
{
    protected $table = "doc_debito_trabalhista";

    public $timestamps = false;

    protected $fillable = [
        'cadastro_id',
        'filename',
        'extensao',
        'status',
        'justificativa'
    ];

    public function cadastro()
    
    {
    return $this->belongsTo(Cadastro::class);
    }
}
