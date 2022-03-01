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
            $table->id();
            $table->bigInteger('rn_id')->index('i_fk_rn')->comment('Identifiant de la route nationale');
            $table->bigInteger('transporteur_id')->index('i_fk_transporteur')->comment('Identifiant du transporteur');
            $table->bigInteger('categorie_id')->index('i_fk_categorie')->comment('Identifiant de la catégorie');
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
