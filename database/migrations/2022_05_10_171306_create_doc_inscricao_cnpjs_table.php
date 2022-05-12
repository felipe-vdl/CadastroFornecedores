<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocInscricaoCnpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_inscricao_cnpj', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cadastro_id')->unsigned();

            $table->string('filename');
            $table->string('extensao', 16);

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
        Schema::dropIfExists('doc_inscricao_cnpj');
    }
}
