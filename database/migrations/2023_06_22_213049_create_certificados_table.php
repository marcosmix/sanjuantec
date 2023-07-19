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
       Schema::create('certificados', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->foreignId('id_alumno')->constrained('alumnos_admin');
            $table->foreignId('id_curso')->constrained('cursos');
            $table->string('directorio');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificados');
    }
};
