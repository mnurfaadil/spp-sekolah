<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nis','15');
            $table->string('nama', '255');
            $table->enum('jenis_kelamin',['L','P']);
            $table->enum('kelas',['X','XI','XII']);
            $table->integer('major_id');
            $table->string('phone','14');
            $table->integer('angkatan_id');
            $table->string('email', '255');
            $table->string('alamat', '255');
            $table->string('tgl_masuk', '255');
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
        Schema::dropIfExists('students');
    }
}
