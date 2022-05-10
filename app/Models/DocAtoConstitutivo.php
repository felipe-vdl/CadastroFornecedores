<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocAtoConstitutivo extends Model
{
    protected $table = "doc_ato_constitutivo";

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
