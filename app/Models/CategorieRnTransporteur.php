<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieRnTransporteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'transporteur_id', 'rn_id', 'categorie_id', 'prix',
    ];


    public function zone()
    {
        return $this->hasOne(Rn::class, 'id', 'rn_id');
    }

    public function categorie()
    {
        return $this->hasOne(Categorie::class, 'id', 'categorie_id');
    }
}
