<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id_task');
            $table->unsignedInteger('id_proyek');
            $table->string('id_pegawai')->nullable();
            $table->string('label_task');
            $table->string('deskripsi_task');
            $table->date('tanggal_plan_awal');
            $table->date('tanggal_plan_akhir');
            $table->dateTime('tanggal_aktual_awal')->nullable();
            $table->dateTime('tanggal_aktual_akhir')->nullable();
            $table->integer('presentase_progress')->default(0);
            $table->string('status');
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
        Schema::dropIfExists('task');
    }
}
