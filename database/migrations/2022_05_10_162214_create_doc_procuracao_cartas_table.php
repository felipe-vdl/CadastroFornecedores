<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocProcuracaoCartasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_procuracao_carta', function (Blueprint $table) {
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
        Schema::dropIfExists('doc_procuracao_carta');
    }
}
