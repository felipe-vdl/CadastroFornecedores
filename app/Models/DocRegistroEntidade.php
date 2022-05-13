<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocRegistroEntidade extends Model
{
    protected $table = "doc_registro_entidade";

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
