<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocBalancoPatrimonial extends Model
{
    protected $table = "doc_balanco_patrimonial";

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
