<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocCreditoTributario extends Model
{
    protected $table = "doc_credito_tributario";

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
