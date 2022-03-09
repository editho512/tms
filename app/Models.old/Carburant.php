<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carburant extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'flux',
        'date',
        'camion_id'
    ];
}