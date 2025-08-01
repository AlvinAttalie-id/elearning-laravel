<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasFile extends Model
{
    protected $fillable = ['tugas_id', 'file_path'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
