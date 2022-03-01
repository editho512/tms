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
            $table->id();
            $table->bigInteger("user_id")->index('i_fk_reservation_client')->comment('Identifiant du client');
            $table->bigInteger("depart_id")->index('i_fk_reservation_depart')->comment('Province de départ de la reservation');
            $table->bigInteger("arrive_id")->index('i_fk_reservation_arrivee')->comment('Ville d\'arrivée de la reservation');
            $table->bigInteger("id_user")->index('i_fk_reservation_transporteur')->comment('Identifiant du transporteur');
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
