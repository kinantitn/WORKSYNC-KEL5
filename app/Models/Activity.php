<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    protected $primaryKey = 'id_activity';
    public $timestamps = false;

    protected $fillable = [
        'id_task',
        'id_pegawai',
        'label_activity',
        'deskripsi_activity',
        'tanggal_plan_awal',
        'tanggal_plan_akhir',
        'tanggal_aktual_awal',
        'tanggal_aktual_akhir',
        'presentase_progress',
        'status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class,'id_task');
    }

    public function employee()
    {
        return $this->belongsTo(Employe::class,'id_pegawai');
    }
}
