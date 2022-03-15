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
            $table->unsignedBigInteger('province_id')->index('i_fk_rn_province');
            $table->unsignedBigInteger('rn_id')->index('i_fk_province_rn');
            $table->timestamps();

            $table->primary(['province_id', 'rn_id']);
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
