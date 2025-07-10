<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'slug',
        'wali_kelas_id',
        'maksimal_siswa',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kelas) {
            $kelas->slug = Str::slug($kelas->nama);

            // Pastikan slug unik (opsional tapi disarankan)
            $originalSlug = $kelas->slug;
            $count = 1;
            while (static::where('slug', $kelas->slug)->exists()) {
                $kelas->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    // Relasi ke model Guru
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'kelas_mata_pelajaran');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
