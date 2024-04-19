<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hafalan;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'AudioManager';

    protected $fillable = ['hafalan_id','path'];

    function hafalan() {
        return $this->belongsTo(Hafalan::class, 'hafalan_id');
    }
}
