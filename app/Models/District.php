<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;


    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
