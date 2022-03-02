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
            $table->primary(['rn_id', 'transporteur_id', 'categorie_id'], 'cate_rn_trans_id');
            $table->bigInteger('rn_id')->index('i_fk_cat_trans_rn')->unsigned()->comment('Identifiant de la route nationale');
            $table->bigInteger('transporteur_id')->unsigned()->index('i_fk_cat_rn_transporteur')->comment('Identifiant du transporteur');
            $table->bigInteger('categorie_id')->unsigned()->index('i_fk_rn_trans_categorie')->comment('Identifiant de la catégorie');
            $table->decimal('prix', 10)->nullable(false);
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
