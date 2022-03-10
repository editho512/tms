<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\VilleRn;
use App\Models\Province;
use App\Models\Categorie;
use App\Models\ProvinceRn;
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
        $depart = ProvinceRn::where("rn_id", $rnID)->get();
        $arrivee = VilleRn::where("rn_id", $rnID)->get();
        
        $categorie = self::whereIn("province_id", $depart->pluck("province_id"))->whereIn("ville_id", $arrivee->pluck("ville_id"))->get();

        return $categorie;
        /*
        $all = CategorieDepart::all();
        foreach ($all as $categorie)
        {
            if (in_array($rnID, $categorie->depart->zones->pluck('id')->toArray()) AND in_array($rnID, $categorie->arrivee->zones->pluck('id')->toArray()))
            {
                $results[] = $categorie;
            }
        }
        return collect($results);
        */

    }
}
