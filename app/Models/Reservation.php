<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'depart_id', 'id', 'client_id', 'arrivee_id', 'transporteur_id', 'date', 'status', 'numero'
    ];

    CONST STATUS = [
        "en attente", "réservé", "livré", "annulé", "rejeté", 'indisponible', 'en retard'
    ];

    /**
     * Tolérence en pourcentage
     */
    CONST TOLERENCE = 50;

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


    /**
     * Province de départ de la reservation
     *
     * @return HasOne
     */
    public function depart() : HasOne
    {
        return $this->hasOne(Province::class, "id", "depart_id");
    }

    /**
     * Transporteur pour la reservation
     *
     * @return HasOne
     */
    public function transporteur() : HasOne
    {
        return $this->hasOne(User::class, "id", "transporteur_id");
    }


    /**
     * Client qui a fait la reservation
     *
     * @return HasOne
     */
    public function client() : HasOne
    {
        return $this->hasOne(User::class, "id", "client_id");
    }


    /**
     * Permet de determiner si la reservation est en attente
     *
     * @return boolean
     */
    public function enAttente() : bool
    {
        return $this->status === self::STATUS[0];
    }


    /**
     * Permet de determiner si la reservation est annulé par le client
     *
     * @return boolean
     */
    public function annule() : bool
    {
        return $this->status === self::STATUS[3];
    }


    /**
     * Permet de determiner si la reservation est accépté par le transporteur
     *
     * @return boolean
     */
    public function reserve() : bool
    {
        return $this->status === self::STATUS[1];
    }


    /**
     * Permet de determiner si la reservation ou le colis est livré
     *
     * @return boolean
     */
    public function livre() : bool
    {
        return $this->status === self::STATUS[2];
    }


    /**
     * Permet de determiner si la reservation est rejete par le transporteur
     *
     * @return boolean
     */
    public function rejete() : bool
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
            return $this->where('numero', $this->numero)->where('status', self::STATUS[0])->orWhere('status', self::STATUS[6])->get();
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


    /**
     * Reservation qui a la meme numero que celle qui est actuelle
     *
     * @param boolean $accepted Si la reservation a rechercher est accepté
     * @return Collection
     */
    public function siblings(bool $accepted = false) : Collection
    {
        if ($accepted === true)
        {
            return $this->where('numero', $this->numero)->where('id', '<>', $this->id)->where('status', self::STATUS[1])->get();
        }
        return $this->where('numero', $this->numero)->where('id', '<>', $this->id)->get();
    }


    /**
     * Permet de determiner si une reservation est indisponible (accepté par un autre transporteur, indisponible pour l'autre)
     *
     * @return boolean
     */
    public function indisponible() : bool
    {
        return $this->status === self::STATUS[5];
    }


    /**
     * Permet de determiner si une reservation est en rétard (la date de depart prevu par le client est dépassé)
     *
     * @return boolean
     */
    public function retard() : bool
    {
        return $this->status === self::STATUS[6];
    }
}
