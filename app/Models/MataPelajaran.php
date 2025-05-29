<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_mapel',
        'guru_id',
    ];

    // Relasi ke model Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'mapel_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mapel_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'mapel_id');
    }
}
