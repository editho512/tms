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

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'zone_districts', 'district_id', 'zone_id');
    }
}
