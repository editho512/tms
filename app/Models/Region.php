<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function villes()
    {
        return $this->hasMany(Ville::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
