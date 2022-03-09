<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->primary(['client_id', 'depart_id', 'arrivee_id', 'transporteur_id'], 'id');
            $table->bigInteger("client_id")->unsigned()->index('i_fk_reservation_client')->comment('Identifiant du client');
            $table->bigInteger("depart_id")->unsigned()->index('i_fk_reservation_depart')->comment('Province (grande ville) de départ de la reservation');
            $table->bigInteger("arrivee_id")->unsigned()->index('i_fk_reservation_arrivee')->comment('Ville d\'arrivée de la reservation');
            $table->bigInteger("transporteur_id")->unsigned()->index('i_fk_reservation_transporteur')->comment('Identifiant du transporteur');
            $table->bigInteger("trajet_id")->unsigned()->index('i_fk_reservation_trajet')->comment('Identifiant du trajet');

            $table->dateTime("date");
            $table->string("status");
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
        Schema::dropIfExists('reservations');
    }
}
