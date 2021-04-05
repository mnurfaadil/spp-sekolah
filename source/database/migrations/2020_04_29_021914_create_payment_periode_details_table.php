<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentPeriodeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_periode_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payment_periode_id');
            $table->integer('payment_id');
            $table->integer('user_id');
            $table->enum('status',['Lunas', 'Nunggak','Waiting']);
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
        Schema::dropIfExists('payment_periode_details');
    }
}
