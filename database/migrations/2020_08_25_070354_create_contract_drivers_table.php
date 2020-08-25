<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->string('name');
            $table->string('phone');
            $table->string('car_plate');
            $table->string('avatar');
            $table->string('car_name');
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
        Schema::dropIfExists('contract_drivers');
    }
}
