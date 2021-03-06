<?php

namespace App\Models;

use App\Models\Depart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartCategorie extends Model
{
    use HasFactory;
    
    protected $fillable = ["depart_id", "id_district", "categorie_id"];

    public $timestamps = false;

    public function depart(){
        return $this->hasOne(Depart::class, "id", "depart_id");
    }

    public function categorie(){
        return $this->hasOne(Categorie::class, "id", "categorie_id");
    }

  
    public function district(){
        return $this->hasOne(District::class, "id", "id_district");
    }

    public static function isSetCategorie($depart, $arrive){
        $departs = Depart::where("district_id", $depart)->get();
        if(isset($departs[0]->id) === true){
            $departCategorie = self::where("depart_id", $departs[0]->id)->where("id_district", $arrive)->get();

            return isset($departCategorie[0]->id);
        }

        return false;
    }
}
