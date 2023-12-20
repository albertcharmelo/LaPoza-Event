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
            $table->boolean('datos_requeridos')->default(false);
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
            $table->dropColumn('datos_requeridos');
        });
    }
};
