<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    protected $table = "cadastro";

    protected $fillable = [
        'razao_social',
        'cnpj',
        'porte_empresa',
        'cnae',
        'produtos',
        'endereco',
        'email',
        'telefone',
    ];

    public function doc_requerimentoinscricao()
{
   return $this->hasMany(RequerimentoInscricao::class);
}

}
