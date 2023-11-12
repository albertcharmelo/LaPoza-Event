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
        Schema::create('invitaciones_imagenes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invitacion_id')->constrained('invitaciones');
            $table->foreignUuid('imagen_id')->constrained('imagenes');
            $table->foreignUuid('creado_por')->constrained('users');            
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
        Schema::dropIfExists('invitaciones_imagenes');
    }
};
