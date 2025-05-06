<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['user_id', 'tanggal', 'nip','shift'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
