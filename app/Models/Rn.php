<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rn extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function villes()
    {
        return $this->belongsToMany(Ville::class, 'ville_rns', 'rn_id', 'ville_id');
    }

    public function grandeVilles()
    {
        return $this->belongsToMany(Province::class, 'province_rns', 'rn_id', 'province_id');
    }

    public function description()
    {
        return 'Description';
    }


    public function provinces()
    {
        return $this->belongsToMany(Province::class, 'province_rns', 'rn_id', 'province_id');
    }
}
