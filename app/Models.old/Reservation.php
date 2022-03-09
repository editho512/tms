<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['depart_id', 'id', 'user_id', 'arrive_id', 'id_user', 'date', 'status', 'numero'];

    CONST STATUS = ["en attente", "réservé", "livré", "annulé", "rejeté", "indisponible"];

    public function arrive()
    {
        return $this->hasOne(District::class, "id", "arrive_id");
    }

    public function depart()
    {
        return $this->hasOne(District::class, "id", "depart_id");
    }

    public function transporteur()
    {
        return $this->hasOne(User::class, "id", "id_user");
    }

    public function client()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function enAttente()
    {
        return $this->status === self::STATUS[0];
    }

    public function annule()
    {
        return $this->status === self::STATUS[3];
    }

    public function reserve()
    {
        return $this->status === self::STATUS[1];
    }

    public function livre()
    {
        return $this->status === self::STATUS[2];
    }

    public function rejete()
    {
        return $this->status === self::STATUS[4];
    }


    public function livrable()
    {
        dd(true);
        $dateDepart = Carbon::parse($this->date, 'EAT');

        $now = Carbon::now();

        if ($dateDepart->lessThanOrEqualTo($now))
        {
            return true;
        }
        return false;
    }
}
