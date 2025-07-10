<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MataPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_mapel',
        'slug',
        'guru_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mapel) {
            $mapel->slug = Str::slug($mapel->nama_mapel);

            // Pastikan slug unik (opsional tapi disarankan)
            $originalSlug = $mapel->slug;
            $count = 1;
            while (static::where('slug', $mapel->slug)->exists()) {
                $mapel->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mata_pelajaran');
    }
}
