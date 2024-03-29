<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocRegularidadeFiscal extends Model
{
    protected $table = "doc_regularidade_fiscal";

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
