<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinceRnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province_rns', function (Blueprint $table) {
            $table->primary(['province_id', 'rn_id']);
            $table->bigInteger('province_id')->unsigned()->index('i_fk_rn_province')->unsigned();
            $table->bigInteger('rn_id')->unsigned()->index('i_fk_province_rn')->unsigned();
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
        Schema::dropIfExists('province_rns');
    }
}
