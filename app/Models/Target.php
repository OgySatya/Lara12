<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tugas_id'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
