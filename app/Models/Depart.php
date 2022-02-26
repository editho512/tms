<?php

namespace App\Models;

use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depart extends Model
{
    use HasFactory;

    protected $fillable = ["district_id"];

    public $timestamps = false;

    public function district(){
        return $this->hasOne(District::class, "id", "district_id");
    }


}
