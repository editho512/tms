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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->index('i_fk_reservation_client')->comment('Identifiant du client');
            $table->unsignedBigInteger('depart_id')->index('i_fk_reservation_depart')->comment('Province (grande ville) de départ de la reservation');
            $table->unsignedBigInteger('arrivee_id')->index('i_fk_reservation_arrivee')->comment('Ville d\'arrivée de la reservation');
            $table->unsignedBigInteger('transporteur_id')->index('i_fk_reservation_transporteur')->comment('Identifiant du transporteur');
            $table->unsignedBigInteger('trajet_id')->nullable();
            $table->dateTime('date');
            $table->string('status');
            $table->timestamps();
            $table->string('numero', 255);
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
