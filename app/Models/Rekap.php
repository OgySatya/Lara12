<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    protected $fillable = ['user_id', 'bulan', 'tahun', 'path',];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   
}
