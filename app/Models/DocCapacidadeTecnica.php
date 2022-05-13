<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocCapacidadeTecnica extends Model
{
    protected $table = "doc_capacidade_tecnica";

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
