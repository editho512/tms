<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['depart_id', 'id', 'client_id', 'arrivee_id', 'transporteur_id', 'date', 'status', 'numero'];

    CONST STATUS = ["en attente", "réservé", "livré", "annulé", "rejeté", 'indisponible'];

    private static $couleurs = [];

    /**
     * Arrivee d'un trajet
     *
     * @return void
     */
    public function arrive()
    {
        return $this->hasOne(Ville::class, "id", "arrivee_id");
    }

    public function depart()
    {
        return $this->hasOne(Province::class, "id", "depart_id");
    }

    public function transporteur()
    {
        return $this->hasOne(User::class, "id", "transporteur_id");
    }

    public function client()
    {
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

    /**
     * Memes numéro de reservation
     *
     * @return Collection
     */
    public function same(bool $enAttente = false) : Collection
    {
        if ($enAttente === true)
        {
            return $this->where('numero', $this->numero)->where('status', self::STATUS[0])->get();
        }
        return $this->where('numero', $this->numero)->get();
    }


    /**
     * Couleurs
     *
     * @return void
     */
    public function couleurs()
    {
        $numero = $this->numero;

        if (key_exists($numero, static::$couleurs))
        {
            return static::$couleurs[$numero];
        }

        $reservations = $this->same();

        foreach ($reservations as $reservation)
        {
            static::$couleurs[$reservation->numero] = "#" . substr(str_repeat(str_shuffle('ABCDEF'), 1), 0, 6);
        }

        return static::$couleurs[$numero];
    }


    public function livrable()
    {
        $dateDepart = Carbon::parse($this->date, 'EAT');
        $now = Carbon::now();

        if ($dateDepart->lessThanOrEqualTo($now))
        {
            return true;
        }
        return false;
    }

    public function siblings(bool $accepted = false) : Collection
    {
        if ($accepted === true)
        {
            return $this->where('numero', $this->numero)->where('id', '<>', $this->id)->where('status', self::STATUS[1])->get();
        }
        return $this->where('numero', $this->numero)->where('id', '<>', $this->id)->get();
    }

    public function indisponible()
    {
        return $this->status === self::STATUS[5];
    }
}
