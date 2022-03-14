<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RnTransporteur extends Model
{
    use HasFactory;

    public function zone(){
        return $this->hasOne(Rn::class, "id", "rn_id");
    }
}
