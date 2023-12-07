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
            $table->dropColumn('imagen_nombre');
            $table->dropColumn('imagen');
            $table->text('texto')->nullable()->change();
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
            $table->string('imagen_nombre')->nullable();
            $table->string('imagen')->nullable();
            $table->text('texto')->nullable(false)->change();
        });
    }
};
