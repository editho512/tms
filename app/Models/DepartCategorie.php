<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Depart;


class DepartCategorie extends Model
{
    use HasFactory;

    protected $fillable = ["depart_id", "id_district", "categorie_id"];

    public $timestamps = false;

    public function depart(){
        return $this->hasOne(District::class, "id", "depart_id");
    }

    public function categorie(){
        return $this->hasOne(Categorie::class, "id", "categorie_id");
    }


    public function district(){
        return $this->hasOne(District::class, "id", "id_district");
    }

    public static function isSetCategorie($depart, $arrive){
        
        $departCategorie = self::where("depart_id", $depart)->where("id_district", $arrive)->get();

        return isset($departCategorie[0]->id);
    }
}
