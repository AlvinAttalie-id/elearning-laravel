<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'tanggal_lahir',
        'alamat',
        'kelas_id',
    ];

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNamaAttribute(): string
    {
        return $this->user->name ?? '-';
    }


    public function jawabanTugas()
    {
        return $this->hasMany(JawabanTugas::class);
    }
}
