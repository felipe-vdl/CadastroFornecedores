<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocCategoria extends Model
{
    protected $table = "doc_categorias";

    public $timestamps = false;

    protected $fillable = [
        'cadastro_id',

        'status_ato_constitutivo',
        'justificativa_ato_constitutivo',
        'status_balanco_patrimonial',
        'justificativa_balanco_patrimonial',
        'status_capacidade_tecnica',
        'justificativa_capacidade_tecnica',
        'status_cedula_identidade',
        'justificativa_cedula_identidade',
        'status_credito_tributario',
        'justificativa_credito_tributario',
        'status_debito_estadual',
        'justificativa_debito_estadual',
        'status_debito_municipal',
        'justificativa_debito_municipal',
        'status_debito_trabalhista',
        'justificativa_debito_trabalhista',
        'status_falencia_concordata',
        'justificativa_falencia_concordata',
        'status_inscricao_cnpj',
        'justificativa_inscricao_cnpj',
        'status_cadastro_contribuinte',
        'justificativa_cadastro_contribuinte',
        'status_procuracao_carta',
        'justificativa_procuracao_carta',
        'status_registro_entidade',
        'justificativa_registro_entidade',
        'status_regularidade_fiscal',
        'justificativa_regularidade_fiscal',
        'status_requerimento_inscricao',
        'justificativa_requerimento_inscricao'
    ];

    public function cadastro()
    
    {
        return $this->belongsTo(Cadastro::class);
    }
}
