<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRelasiDiTabelPaymentPeriodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_periodes', function (Blueprint $table) {
            $table->integer('major_id')->after('financing_category_id');
            $table->integer('angkatan_id')->after('financing_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_periodes', function (Blueprint $table) {
            $table->dropColumn('major_id');
            $table->dropColumn('angkatan_id');
        });
    }
}
