<?php

namespace App\Models;

use App\Models\ZoneCommune;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public $timestamps = false;

    public function getDistrictId(){
        $district = ZoneDistrict::where('zone_id', $this->id)->get();

        return isset($district[0]->district_id) === true ?  $district->pluck("district_id") : [];
    }

}
