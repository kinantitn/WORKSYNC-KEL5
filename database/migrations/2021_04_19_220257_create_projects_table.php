<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->increments('id_proyek');
            $table->string('id_pegawai')->nullable();
            $table->string('nama_proyek');
            $table->date('tanggal_plan_awal_proyek');
            $table->date('tanggal_plan_akhir_proyek');
            $table->date('tanggal_aktual_awal_proyek')->nullable();
            $table->date('tanggal_aktual_akhir_proyek')->nullable();
            $table->string( 'status');
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
        Schema::dropIfExists('projects');
    }
}
