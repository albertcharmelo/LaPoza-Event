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
        Schema::table('invitaciones_imagenes', function (Blueprint $table) {            
            $table->string('tipo_imagen')->after('imagen_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invitaciones_imagenes', function (Blueprint $table) {
            $table->dropColumn('tipo_imagen');
        });
    }
};
