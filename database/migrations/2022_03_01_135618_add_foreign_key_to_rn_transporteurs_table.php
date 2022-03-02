<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToRnTransporteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rn_transporteurs', function (Blueprint $table) {
            $table->foreign(['user_id'], 'i_fk_transporteur')->references(['id'])->on('users');
            $table->foreign(['rn_id'], 'i_fk_rn')->references(['id'])->on('rns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rn_transporteurs', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('rn_id');
        });
    }
}
