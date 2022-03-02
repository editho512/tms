<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToCategorieRnTransporteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorie_rn_transporteurs', function (Blueprint $table) {
            $table->foreign(['rn_id'], 'i_fk_cat_trans_rn')->references(['id'])->on('rns');
            $table->foreign(['transporteur_id'], 'i_fk_cat_rn_transporteur')->references(['id'])->on('users');
            $table->foreign(['categorie_id'], 'i_fk_rn_trans_categorie')->references(['id'])->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorie_rn_transporteurs', function (Blueprint $table) {
            $table->dropForeign('rn_id');
            $table->dropForeign('transporteur_id');
            $table->dropForeign('categorie_id');
        });
    }
}
