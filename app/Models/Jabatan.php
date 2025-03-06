<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = ['name','user_id'];

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
