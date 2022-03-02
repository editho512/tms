<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToProvinceRnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('province_rns', function (Blueprint $table) {
            $table->foreign(['province_id'], 'i_fk_rn_province')->references(['id'])->on('provinces');
            $table->foreign(['rn_id'], 'i_fk_province_rn')->references(['id'])->on('rns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('province_rns', function (Blueprint $table) {
            //
        });
    }
}
