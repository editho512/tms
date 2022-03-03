<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    
    public function zones()
    {
        return $this->belongsToMany(Rn::class, 'province_rns', 'province_id', 'rn_id');
    }
}
