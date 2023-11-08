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
        Schema::create('invitaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('texto');
            $table->string('imagen')->nullable();
            $table->enum('tipo_menu', ['Menu Fijo con Precio', 'Menu Fijo sin Precio', 'Menu a Elegir con Precio', 'Menu a Elegir sin Precio']);
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
        Schema::dropIfExists('invitaciones');
    }
};
