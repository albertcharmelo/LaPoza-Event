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
        Schema::create('invitados', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invitacion_id')->constrained('invitaciones');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('email');
            $table->string('nif');
            $table->integer('numero_personas');
            $table->text('observaciones')->nullable();
            $table->boolean('asistencia_confirmada')->default(false);
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
        Schema::dropIfExists('invitados');
    }
};
