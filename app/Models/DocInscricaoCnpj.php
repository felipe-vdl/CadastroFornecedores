<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocInscricaoCnpj extends Model
{
    protected $table = "doc_inscricao_cnpj";

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
