<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';

    protected $primaryKey = 'id_task';
    public $timestamps = false;

    protected $fillable = [
        'id_proyek',
        'id_pegawai',
        'label_task',
        'deskripsi_task',
        'tanggal_plan_awal',
        'tanggal_plan_akhir',
        'tanggal_aktual_awal',
        'tanggal_aktual_akhir',
        'presentase_progress',
        'status',
    ];

    public function subtasks()
    {
        return $this->hasMany(Activity::class,'id_task');
    }

    public function employee()
    {
        return $this->belongsTo(Employe::class,'id_pegawai');
    }
}
