<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cadastro_id')->unsigned();

            $table->tinyInteger('status_ato_constitutivo')->default(0);
            $table->text('justificativa_ato_constitutivo')->nullable();
            $table->tinyInteger('status_balanco_patrimonial')->default(0);
            $table->text('justificativa_balanco_patrimonial')->nullable();
            $table->tinyInteger('status_capacidade_tecnica')->default(0);
            $table->text('justificativa_capacidade_tecnica')->nullable();
            $table->tinyInteger('status_cedula_identidade')->default(0);
            $table->text('justificativa_cedula_identidade')->nullable();
            $table->tinyInteger('status_credito_tributario')->default(0);
            $table->text('justificativa_credito_tributario')->nullable();
            $table->tinyInteger('status_debito_estadual')->default(0);
            $table->text('justificativa_debito_estadual')->nullable();
            $table->tinyInteger('status_debito_municipal')->default(0);
            $table->text('justificativa_debito_municipal')->nullable();
            $table->tinyInteger('status_debito_trabalhista')->default(0);
            $table->text('justificativa_debito_trabalhista')->nullable();
            $table->tinyInteger('status_falencia_concordata')->default(0);
            $table->text('justificativa_falencia_concordata')->nullable();
            $table->tinyInteger('status_inscricao_cnpj')->default(0);
            $table->text('justificativa_inscricao_cnpj')->nullable();
            $table->tinyInteger('status_procuracao_carta')->default(0);
            $table->text('justificativa_procuracao_carta')->nullable();
            $table->tinyInteger('status_registro_entidade')->default(0);
            $table->text('justificativa_registro_entidade')->nullable();
            $table->tinyInteger('status_regularidade_fiscal')->default(0);
            $table->text('justificativa_regularidade_fiscal')->nullable();
            $table->tinyInteger('status_requerimento_inscricao')->default(0);
            $table->text('justificativa_requerimento_inscricao')->nullable();

            $table->foreign('cadastro_id')->references('id')->on('cadastros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_categorias');
    }
}
