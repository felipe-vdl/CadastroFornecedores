<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimentoInscricaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_requerimentoinscricao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cadastro_id')->unsigned();

            $table->string('filename');
            $table->string('extensao', 16);

            $table->foreign('cadastro_id')->references('id')->on('cadastro')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento_requerimentoinscricao');
    }
}
