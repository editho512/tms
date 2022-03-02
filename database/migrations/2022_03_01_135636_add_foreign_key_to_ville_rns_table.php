<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToVilleRnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ville_rns', function (Blueprint $table) {
            $table->foreign(['ville_id'], 'i_fk_rn_ville')->references(['id'])->on('villes');
            $table->foreign(['rn_id'], 'i_fk_ville_rn')->references(['id'])->on('rns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ville_rns', function (Blueprint $table) {
            $table->dropForeign('i_fk_ville');
            $table->dropForeign('i_fk_rn');
        });
    }
}
