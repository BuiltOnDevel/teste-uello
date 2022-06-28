<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LocaleShip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locale_ship', function (Blueprint $table) {
            $table->integer('from_postcode');
            $table->integer('to_postcode');
            $table->double('from_weight',7,2);
            $table->double('to_weight',7,2);
            $table->double('cost',9,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('locale_ship');
    }
}
