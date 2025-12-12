<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'jabatan_id','post'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function target()
    {
        return $this->hasMany(Target::class);
    }
}
