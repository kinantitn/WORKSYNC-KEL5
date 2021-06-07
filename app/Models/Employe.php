<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'pegawai';

    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'NIP',
        'nama_lengkap',
        'foto',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

}
