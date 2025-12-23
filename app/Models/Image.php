<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'target_id','image',];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function target()
    {
        return $this->belongsTo(Target::class, 'target_id');
    }
}
