<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCategorieRnTransporteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorie_rn_transporteurs', function (Blueprint $table) {
            $table->foreign(['transporteur_id'], 'i_fk_cat_rn_transporteur')->references(['id'])->on('users');
            $table->foreign(['categorie_id'], 'i_fk_rn_trans_categorie')->references(['id'])->on('categories');
            $table->foreign(['rn_id'], 'i_fk_cat_trans_rn')->references(['id'])->on('rns');
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
            $table->dropForeign('i_fk_cat_rn_transporteur');
            $table->dropForeign('i_fk_rn_trans_categorie');
            $table->dropForeign('i_fk_cat_trans_rn');
        });
    }
}
