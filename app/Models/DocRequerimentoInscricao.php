<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocRequerimentoInscricao extends Model
{
    protected $table = "doc_requerimento_inscricao";

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
