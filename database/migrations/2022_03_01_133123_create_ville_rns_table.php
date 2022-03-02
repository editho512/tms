<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVilleRnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ville_rns', function (Blueprint $table) {
            $table->primary(['ville_id', 'rn_id'], 'ville_rn_id');
            $table->bigInteger('ville_id')->unsigned()->index('i_fk_rn_ville')->comment('Identifiant de la ville');
            $table->bigInteger('rn_id')->unsigned()->index('i_fk_ville_rn')->comment('Identifiant de la route nationale');
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
        Schema::dropIfExists('ville_rns');
    }
}
