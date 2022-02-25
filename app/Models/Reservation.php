<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    CONST STATUS = ["en attente", "réservé", "livré"];

    public function arrive(){
        return $this->hasOne(District::class, "id", "arrive_id");
    }

    public function depart(){
        return $this->hasOne(District::class, "id", "depart_id");
    }

    public function transporteur(){
        return $this->hasOne(User::class, "id", "id_user");
    }
    public function client(){
        return $this->hasOne(User::class, "id", "user_id");
    }
}
