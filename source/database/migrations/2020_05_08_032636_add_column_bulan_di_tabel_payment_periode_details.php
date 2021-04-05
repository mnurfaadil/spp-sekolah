<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnBulanDiTabelPaymentPeriodeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_periode_details', function (Blueprint $table) {
            $table->date('bulan')->after('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_periode_details', function (Blueprint $table) {
            $table->dropColumn('bulan');
        });
    }
}
