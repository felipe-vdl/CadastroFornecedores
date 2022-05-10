<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocCedulaIdentidade extends Model
{
    protected $table = "doc_cedula_identidade";

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
