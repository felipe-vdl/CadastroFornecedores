<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocCadastroContribuintesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_cadastro_contribuinte', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cadastro_id')->unsigned();

            $table->string('filename');
            $table->string('extensao', 16);

            $table->tinyInteger('status');
            $table->string('justificativa')->nullable();

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
        Schema::dropIfExists('doc_cadastro_contribuintes');
    }
}
