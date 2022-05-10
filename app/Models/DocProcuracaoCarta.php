<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocProcuracaoCarta extends Model
{
    protected $table = "doc_procuracao_carta";

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
