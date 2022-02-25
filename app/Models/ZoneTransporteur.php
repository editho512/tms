<?php

namespace App\Models;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoneTransporteur extends Model
{
    use HasFactory;

    protected $fillable = ["zone_id", "user_id"];

    public $timestamps = false;

    public function zone(){
        return Zone::find($this->zone_id);
    }

    public function description(){
        $districts = ZoneDistrict::where("zone_id", $this->zone_id)->get();

        $res = "";
        foreach ($districts as $key => $value) {
            if($key < 3){
                $res .= ($res === "") ? $value->District->nom : " - " .$value->District->nom ;
            }
        }

        return $res;
    }

    public static function isSetZone($zone_id){
        $mes_zones = self::where("zone_id", $zone_id)->get();
        return isset($mes_zones[0]->id);
    }

}
