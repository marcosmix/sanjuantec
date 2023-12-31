<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre',340);
            $table->unsignedBigInteger('programa_id')->nullable();
            $table->text('texto');
            $table->text('bloque');
            $table->string('duracion',380);
            $table->string('fecha',400);
            ;
        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
