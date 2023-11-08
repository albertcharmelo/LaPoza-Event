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
        Schema::create('menu_opciones', function (Blueprint $table) {
            $table->uuid();
            $table->foreignUuid('invitacion_id')->constrained('invitaciones');
            $table->foreignUuid('evento_id')->constrained('eventos');
            $table->foreignUuid('invitado_id')->constrained('invitados');
            $table->string('opcion'); // Descripción del menú opcional
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
        Schema::dropIfExists('menu_opciones');
    }
};
