<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'iso_code', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function cities()
    {
        return $this->hasMany(Target::class);
    }
}
