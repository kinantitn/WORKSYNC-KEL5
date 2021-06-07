<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'proyek';

    protected $primaryKey = 'id_proyek';
    public $timestamps = false;

    protected $fillable = [
        'nama_proyek',
        'tanggal_plan_awal_proyek',
        'tanggal_plan_akhir_proyek',
        'tanggal_aktual_awal_proyek',
        'tanggal_aktual_akhir_proyek',
        'status'
    ];


    public function tasks()
    {
        return $this->hasMany(Task::class,'id_proyek');
    }
}
