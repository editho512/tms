<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieDepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_departs', function (Blueprint $table) {
            $table->id();
            $table->integer('delais_approximatif')->nullable(true);
            $table->bigInteger('provinde_id')->index('i_fk_depart')->comment('Province de départ. Ex: Tana, Tamatave');
            $table->bigInteger('ville_id')->index('i_fk_arrivee')->comment('Ville d\'arrivée. Ex: Manjakandriana');
            $table->bigInteger('categorie_id')->index('i_fk_categorie')->comment('Catégorie a mettre pour ce trajet. Ex: A, B');
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
        Schema::dropIfExists('categorie_departs');
    }
}
