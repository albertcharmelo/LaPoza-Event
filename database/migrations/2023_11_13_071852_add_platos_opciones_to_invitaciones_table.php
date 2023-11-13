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
        Schema::table('invitaciones', function (Blueprint $table) {            
            $table->json('platos_opciones')->nullable()->after('tipo_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invitaciones', function (Blueprint $table) {
            $table->dropColumn('platos_opciones');
        });
    }
};
