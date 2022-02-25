<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneDistrict extends Model
{
    use HasFactory;

    protected $fillable = ["zone_id", "district_id"];

    public $timestamps = false;

    public function district(){
        
        return $this->hasOne(District::class, "id", "district_id");
    }

}
