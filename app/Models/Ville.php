<?php

namespace App\Models;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ville extends Model
{
    use HasFactory;

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Rn::class, 'ville_rns', 'ville_id', 'rn_id');
    }
}
