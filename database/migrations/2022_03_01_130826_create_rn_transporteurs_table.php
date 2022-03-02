<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRnTransporteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rn_transporteurs', function (Blueprint $table) {
            $table->primary(['user_id', 'rn_id'], 'rn_trans_id');
            $table->bigInteger('user_id')->unsigned()->index('i_fk_transporteur')->comment('Identifiant du transporteur');
            $table->bigInteger('rn_id')->unsigned()->index('i_fk_rn')->comment('Identifiant de la route nationale');
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
        Schema::dropIfExists('rn_transporteurs');
    }
}
