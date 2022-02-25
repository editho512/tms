<?php

namespace App\Models;

use App\Models\CategoriePrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    public function prix(){
        $prix = CategoriePrix::where("categorie_id", $this->id)->where("user_id", auth()->user()->id)->get();

        return isset($prix[0]->id) === true ? $prix[0]->montant : 0;
    }

}
