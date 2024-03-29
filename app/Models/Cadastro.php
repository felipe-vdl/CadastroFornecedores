<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    protected $table = "cadastros";

    protected $fillable = [
        'razao_social',
        'cnpj',
        'porte_empresa',
        'cnae',
        'inscricao_municipal',
        'inscricao_estadual',
        'produtos',
        'cep',
        'rua',
        'numero_rua',
        'bairro',
        'municipio',
        'email',
        'telefone',
        'status',
        'dados',
        'justificativa',
        'avaliador_id',
        'data_avaliacao',
        'data_certificado',
        'validade_certificado',
        'envio_create',
        'envio_avaliacao',
    ];

    public function doc_requerimentoinscricao()
    {
    return $this->hasMany(DocRequerimentoInscricao::class);
    }

    public function doc_atoconstitutivo()
    {
    return $this->hasMany(DocAtoConstitutivo::class);
    }

    public function doc_procuracaocarta()
    {
    return $this->hasMany(DocProcuracaoCarta::class);
    }

    public function doc_cedulaidentidade()
    {
    return $this->hasMany(DocCedulaIdentidade::class);
    }

    public function doc_registroentidade()
    {
    return $this->hasMany(DocRegistroEntidade::class);
    }

    public function doc_inscricaocnpj()
    {
    return $this->hasMany(DocInscricaoCnpj::class);
    }

    public function doc_cadastrocontribuinte()
    {
    return $this->hasMany(DocCadastroContribuinte::class);
    }

    public function doc_balancopatrimonial()
    {
    return $this->hasMany(DocBalancoPatrimonial::class);
    }

    public function doc_regularidadefiscal()
    {
    return $this->hasMany(DocRegularidadeFiscal::class);
    }

    public function doc_creditotributario()
    {
    return $this->hasMany(DocCreditoTributario::class);
    }

    public function doc_debitoestadual()
    {
    return $this->hasMany(DocDebitoEstadual::class);
    }

    public function doc_debitomunicipal()
    {
    return $this->hasMany(DocDebitoMunicipal::class);
    }

    public function doc_falenciaconcordata()
    {
    return $this->hasMany(DocFalenciaConcordata::class);
    }

    public function doc_debitotrabalhista()
    {
    return $this->hasMany(DocDebitoTrabalhista::class);
    }

    public function doc_capacidadetecnica()
    {
    return $this->hasMany(DocCapacidadeTecnica::class);
    }

   public function doc_categorias()
   {
       return $this->hasOne(DocCategoria::class);
   }

   public function funcionario()
   {
      return $this->belongsTo(Funcionario::class, 'avaliador_id');
   }
}
