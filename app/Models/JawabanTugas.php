<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanTugas extends Model
{
    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'jawaban',
        'file_path',
        'submitted_at',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
