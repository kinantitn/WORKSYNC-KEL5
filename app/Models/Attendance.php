<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'absensi';

    protected $primaryKey = 'id_absensi';
    public $timestamps = false;

    protected $fillable = [
        'id_pegawai',
        'jam_masuk',
        'jam_keluar',
    ];

    public function employee()
    {
        return $this->belongsTo(Employe::class,'id_pegawai');
    }
}
