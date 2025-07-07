<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'judul',
        'deskripsi',
        'link_video',
        'tanggal_deadline',
    ];

    protected $casts = [
        'tanggal_deadline' => 'date',
    ];

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanTugas::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function files()
    {
        return $this->hasMany(TugasFile::class);
    }
}
