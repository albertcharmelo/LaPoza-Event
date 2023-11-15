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
        Schema::table('codigo_qr', function (Blueprint $table) {
            $table->foreignUuid('invitado_id')->after('id')->nullable()->constrained('invitados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codigo_qr', function (Blueprint $table) {
            $table->dropForeign(['invitado_id']);
            $table->dropColumn('invitado_id');
        });
    }
};
