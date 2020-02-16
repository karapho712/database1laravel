<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnidatabases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('id_periode')->nullable();
            $table->string('tingkat_kompetensi')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_pengambilan')->nullable();
            $table->string('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('alumniDatabase');
    }
}
