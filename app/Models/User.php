<?php

namespace App\Models;

use App\Models\Camion;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'type', 'password',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Rétourne tous kes types d'utilisateurs existants
     * ou privilèges des utilisateurs
     *
     * @return array Tableau contenant tous les types
     */
    public function getTypeUtilisateurs() : array
    {
        $typeUtilisateurs = Config::get('constants.user_type');
        $typeUtilisateursIndex = [];

        foreach ($typeUtilisateurs as $key => $value)
        {
            $typeUtilisateursIndex[] = $key;
        }

        return $typeUtilisateursIndex;
    }


    /**
     * Verifier si l'utilisateur est un super administrateur
     *
     * @return boolean true: super admin, false: autres
     */
    public function estSuperAdmin() : bool
    {
        return $this->type === 'superAdmin';
    }


    /**
     * Verifier si l'utilisateur est un admin
     *
     * @return boolean true: super admin, false: autres
     */
    public function isAdmin() : bool
    {
        return $this->type === 'admin';
    }


    public function isClient() : bool
    {
        if ($this->type === 'client')
        {
            return true;
        }
        return false;
    }

    public function camions()
    {
        return $this->hasMany(Camion::class);
    }


    public function chauffeurs() : HasMany
    {
        return $this->hasMany(Chauffeur::class);
    }


    public function prixCategorie(int $idCategorie, int $zone)
    {
        $categoriePrix = CategorieRnTransporteur::where('categorie_id', $idCategorie)->where('transporteur_id', $this->id)->where('rn_id', $zone)->first();

        if ($categoriePrix === null)
        {
            return 0;
        }
        return $categoriePrix->prix;
    }

    public function isSameAs(User $user)
    {
        if ($this->id === $user->id) return true;
        return false;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id', 'id');
    }

    public function reservationsTransporteur()
    {
        return $this->hasMany(Reservation::class, 'transporteur_id', 'id');
    }


    public function zones()
    {
        return $this->belongsToMany(Rn::class, 'rn_transporteurs', 'user_id', 'rn_id');
    }


    public function categorieRnTrans()
    {
        return $this->hasMany(CategorieRnTransporteur::class, 'transporteur_id', 'id');
    }


    /**
     * Recuperer tous les camions disponibles d'un transporteur en fonction d'une date
     *
     * @param string $date Date et heure de départ de la reservation du client
     * @return Collection
     */
    public function CamionDisponible(string $date)
    {
        $camion = Camion::where("user_id", $this->id)->where('blocked', 0)->get();
        $dispo = collect();

        if( $camion->count() > 0)
        {

            $camions =  $camion->count() > 0 ? " camion_id IN (".implode(",", $camion->pluck("id")->toArray()).") AND " : "";

            $sql = 'SELECT distinct(camion_id) FROM trajets WHERE '.$camions.'  date_heure_depart IS NOT NULL AND date_heure_arrivee IS NOT NULL AND  date_heure_depart < "'.$date.'" AND date_heure_arrivee > "'.$date.'"   ';

            $indispo =  DB::select(DB::raw($sql));
            $dispo = Camion::where("user_id", $this->id)->whereNotIn("id", array_column($indispo, 'camion_id'))->get();
        }

        return $dispo;
    }


    /**
     * Recuperer tous les chauffeurs disponibles d'un transporteur en fonction d'une date
     *
     * @param string $date Date et heure de départ du client
     * @return Collection
     */
    public function ChauffeurDisponible(string $date)
    {

        $chauffeur = Chauffeur::where("user_id", $this->id)->where('blocked', 0)->get();
        $dispo = collect();

        if( $chauffeur->count() > 0){

            $chauffeurs =  $chauffeur->count() > 0 ? " chauffeur_id IN (".implode(",", $chauffeur->pluck("id")->toArray()).") AND " : "";

            $sql = 'SELECT distinct(chauffeur_id) FROM trajets WHERE '.$chauffeurs.'  date_heure_depart IS NOT NULL AND date_heure_arrivee IS NOT NULL AND  date_heure_depart < "'.$date.'" AND date_heure_arrivee > "'.$date.'"  ';

            $indispo =  DB::select(DB::raw($sql));
            $dispo = Chauffeur::where("user_id", $this->id)->whereNotIn("id", array_column($indispo, 'chauffeur_id'))->get();
        }


        return $dispo;
    }
}
