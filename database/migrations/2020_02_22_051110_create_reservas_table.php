<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('intIdRes')->uniqid();
            $table->string('varNom',200);
            $table->string('varApe',200);
            $table->string('varEmai',300);
            $table->integer('intTel');
            $table->date('dateRes');
            $table->time('timeRes');
            $table->text('varLugar');
            $table->integer('intCant');
            $table->text('varCom');
            $table->datetime('dateResF');
            $table->datetime('dateModi')->nullable();
            $table->string('varCodeReserva',500)->nullable();
            $table->integer('intEst');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
