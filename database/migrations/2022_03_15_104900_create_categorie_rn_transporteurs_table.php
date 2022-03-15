<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieRnTransporteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_rn_transporteurs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('rn_id')->index('i_fk_cat_trans_rn')->comment('Identifiant de la route nationale');
            $table->unsignedBigInteger('transporteur_id')->index('i_fk_cat_rn_transporteur')->comment('Identifiant du transporteur');
            $table->unsignedBigInteger('categorie_id')->index('i_fk_rn_trans_categorie')->comment('Identifiant de la catégorie');
            $table->decimal('prix', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_rn_transporteurs');
    }
}
