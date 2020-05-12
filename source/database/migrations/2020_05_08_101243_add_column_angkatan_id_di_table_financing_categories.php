<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAngkatanIdDiTableFinancingCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financing_categories', function (Blueprint $table) {
            $table->integer('angkatan_id')->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financing_categories', function (Blueprint $table) {
            $table->dropColumn('angkatan_id');
        });
    }
}
