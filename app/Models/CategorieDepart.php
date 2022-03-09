<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\Province;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieDepart extends Model
{
    use HasFactory;

    protected $fillable = [
        "province_id", "ville_id", "categorie_id", "delais_approximatif",
    ];


    public function depart()
    {
        return $this->hasOne(Province::class, "id", "province_id");
    }

    public function arrivee()
    {
        return $this->hasOne(Ville::class, "id", "ville_id");
    }

    public function categorie()
    {
        return $this->hasOne(Categorie::class, "id", "categorie_id");
    }

    public static function getAllIn(int $rnID)
    {
        $results = [];
        $all = CategorieDepart::all();

        foreach ($all as $categorie)
        {
            if (in_array($rnID, $categorie->depart->zones->pluck('id')->toArray()) AND in_array($rnID, $categorie->arrivee->zones->pluck('id')->toArray()))
            {
                $results[] = $categorie;
            }
        }

        return collect($results);
    }
}
