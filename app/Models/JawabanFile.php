<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanFile extends Model
{
    protected $fillable = ['jawaban_tugas_id', 'file_path', 'tipe'];

    public function jawaban()
    {
        return $this->belongsTo(JawabanTugas::class, 'jawaban_tugas_id');
    }
}
