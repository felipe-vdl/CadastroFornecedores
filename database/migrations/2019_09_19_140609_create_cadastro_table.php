<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadastroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razao_social');
            $table->string('cnpj',20);
            $table->string('porte_empresa');
            $table->string('cnae')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->string('produtos');
            $table->string('cep', 9);
            $table->string('rua');
            $table->string('numero_rua');
            $table->string('bairro');
            $table->string('municipio');
            $table->string('email');
            $table->string('telefone');
            $table->string('chave');
            $table->tinyInteger('status');
            $table->tinyInteger('dados');
            $table->string('justificativa')->nullable();
            $table->date('data_avaliacao')->nullable();
            $table->date('data_certificado')->nullable();
            $table->date('validade_certificado')->nullable();
            $table->tinyInteger('envio_create')->nullable();
            $table->tinyInteger('envio_avaliacao')->nullable();
            $table->timestamps();

            $table->integer('avaliador_id')->nullable()->unsigned();
            $table->foreign('avaliador_id')->references('id')->on('funcionarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cadastros');
    }
}
