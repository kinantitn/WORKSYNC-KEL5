<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id_activity');
            $table->unsignedInteger('id_task');
            $table->string('id_pegawai')->nullable();
            $table->string('label_activity');
            $table->string('deskripsi_activity');
            $table->date('tanggal_plan_awal');
            $table->date('tanggal_plan_akhir');
            $table->dateTime('tanggal_aktual_awal')->nullable();
            $table->dateTime('tanggal_aktual_akhir')->nullable();
            $table->integer('presentase_progress');
            $table->string('status')->default('new');
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
        Schema::dropIfExists('activity');
    }
}
