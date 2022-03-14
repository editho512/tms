<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign(['arrivee_id'], 'i_fk_reservation_arrivee')->references(['id'])->on('villes');
            $table->foreign(['depart_id'], 'i_fk_reservation_depart')->references(['id'])->on('provinces');
            $table->foreign(['client_id'], 'i_fk_reservation_client')->references(['id'])->on('users');
            $table->foreign(['transporteur_id'], 'i_fk_reservation_transporteur')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('i_fk_reservation_arrivee');
            $table->dropForeign('i_fk_reservation_depart');
            $table->dropForeign('i_fk_reservation_client');
            $table->dropForeign('i_fk_reservation_transporteur');
        });
    }
}
