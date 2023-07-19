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
        Schema::create('mails_enviados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumno');
            $table->string('id_certificado', 5)->index();
            $table->boolean('estado')->default(false);
            $table->timestamps();

            // Restricción de claves foráneas.
            $table->foreign('id_alumno')->references('id')->on('alumnos_admin');
            $table->foreign('id_certificado')->references('id')->on('certificados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mails_enviados');
    }
};
