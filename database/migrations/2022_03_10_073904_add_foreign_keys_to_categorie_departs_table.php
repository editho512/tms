<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCategorieDepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorie_departs', function (Blueprint $table) {
            $table->foreign(['ville_id'], 'i_fk_arrivee')->references(['id'])->on('villes');
            $table->foreign(['province_id'], 'i_fk_depart')->references(['id'])->on('provinces');
            $table->foreign(['categorie_id'], 'i_fk_categorie')->references(['id'])->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorie_departs', function (Blueprint $table) {
            $table->dropForeign('i_fk_arrivee');
            $table->dropForeign('i_fk_depart');
            $table->dropForeign('i_fk_categorie');
        });
    }
}
