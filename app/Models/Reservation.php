<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['depart_id', 'id', 'client_id', 'arrivee_id', 'transporteur_id', 'date', 'status'];

    CONST STATUS = ["en attente", "réservé", "livré", "annulé", "rejeté"];

    public function arrive(){
        return $this->hasOne(Ville::class, "id", "arrivee_id");
    }

    public function depart(){
        return $this->hasOne(Province::class, "id", "depart_id");
    }

    public function transporteur(){
        return $this->hasOne(User::class, "id", "transporteur_id");
    }
    public function client(){
        return $this->hasOne(User::class, "id", "client_id");
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
        $dateDepart = Carbon::parse($this->date_depart, 'EAT');
        $now = Carbon::now();

        if ($dateDepart->lessThanOrEqualTo($now))
        {
            return false;
        }
        return true;
    }
}
