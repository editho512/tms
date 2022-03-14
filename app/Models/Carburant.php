<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carburant extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'flux',
        'date',
        'camion_id'
    ];

    public function stock(){
        $entre =  DB::select(DB::raw("SELECT sum(quantite) as valeur FROM carburants where flux = 0"));
        $sortie =  DB::select(DB::raw("SELECT sum(quantite) as valeur FROM carburants where flux = 1"));

        
       return doubleval($entre[0]->valeur) -  doubleval($sortie[0]->valeur);
    }
}
