<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tugas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tugas';

    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'judul',
        'slug',
        'deskripsi',
        'link_video',
        'tanggal_deadline',
        'versi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tugas) {
            $tugas->slug = Str::slug($tugas->judul);

            // Pastikan slug unik (opsional tapi disarankan)
            $originalSlug = $tugas->slug;
            $count = 1;
            while (static::where('slug', $tugas->slug)->exists()) {
                $tugas->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'tanggal_deadline' => 'date',
    ];

    public function mataPelajaran()
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
