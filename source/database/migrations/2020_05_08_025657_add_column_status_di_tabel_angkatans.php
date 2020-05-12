<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusDiTabelAngkatans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('angkatans', function (Blueprint $table) {
            $table->enum('status',['X','XI','XII','ALUMNI'])->after('tahun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('angkatans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
