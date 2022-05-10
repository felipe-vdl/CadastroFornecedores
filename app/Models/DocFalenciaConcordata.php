<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocFalenciaConcordata extends Model
{
    protected $table = "doc_falencia_concordata";

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
