<?php

namespace App\Models;

use App\Models\Camion;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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


    /**
     * Recuperer le prix d'un caégorie d'un transporteur en fonction de la zone de travail
     *
     * @param integer $idCategorie
     * @param integer $zone
     * @return void
     */
    public function prixCategorie(int $idCategorie, int $zone) : float
    {
        $categoriePrix = CategorieRnTransporteur::where('categorie_id', $idCategorie)->where('transporteur_id', $this->id)->where('rn_id', $zone)->first();

        if ($categoriePrix === null)
        {
            return 0.0;
        }
        return doubleval($categoriePrix->prix);
    }


    /**
     * Detecter si un utilisateur est le meme que l'utilisateur passé en parametre
     *
     * @param User $user
     * @return boolean
     */
    public function isSameAs(User $user) : bool
    {
        if ($this->id === $user->id) return true;
        return false;
    }


    /**
     * Recuperer tous les reserations d'un client
     *
     * @return HasMany
     */
    public function reservations() : HasMany
    {
        return $this->hasMany(Reservation::class, 'client_id', 'id');
    }


    /**
     * Recuperer tous les reservation d'un transporteur
     *
     * @return HasMany
     */
    public function reservationsTransporteur() : HasMany
    {
        return $this->hasMany(Reservation::class, 'transporteur_id', 'id');
    }


    /**
     * Recuperer tous les zones de transport d'un transporteur
     *
     * @return BelongsToMany
     */
    public function zones() : BelongsToMany
    {
        return $this->belongsToMany(Rn::class, 'rn_transporteurs', 'user_id', 'rn_id');
    }


    /**
     * Recuperer les categories et les prix d'un transporteurainsi que la zone choisi
     *
     * @return HasMany
     */
    public function categorieRnTrans() : HasMany
    {
        return $this->hasMany(CategorieRnTransporteur::class, 'transporteur_id', 'id');
    }


    /**
     * Recuperer tous les camions disponibles d'un transporteur en fonction d'une date
     *
     * @param string $date Date et heure de départ de la reservation du client
     * @param string $dateArriveeApproximatif Date et heure d'arrivee approximatif
     * @return Collection
     */
    /*
    public function CamionDisponible(string $date, string $dateArriveeApproximatif)
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
    }*/

    /**
     * Recuperer tous les camions disponibles d'un transporteur en fonction d'une date
     *
     * @param string $date Date et heure de départ de la reservation du client
     * @param string $dateArriveeApproximatif Date et heure d'arrivee approximatif
     * @return Collection
     */
    public function CamionDisponible(string $dateDepart, string $dateArriveeApproximatif = null)
    {
        $camions = $this->camions()->where('blocked', 0)->get();
        $camionsDisponibles = [];

        foreach ($camions as $camion)
        {
            if ($camion->aUnTrajetEntre($dateDepart, $dateArriveeApproximatif) === false)
            {
                $camionsDisponibles[] = $camion;
            }
        }

        return collect($camionsDisponibles);
    }

        /**
     * Recuperer tous les chauffeurs disponibles d'un transporteur en fonction d'une date
     *
     * @param string $date Date et heure de départ du client
     * @param string $dateArriveeApproximatif Date et heure d'arrivee approximatif
     * @return Collection
     */
    public function ChauffeurDisponible(string $dateDepart, string $dateArriveeApproximatif = null)
    {
        $chauffeurs = $this->chauffeurs()->where('blocked', 0)->get();
        $chauffeursDisponibles = [];

        foreach ($chauffeurs as $chauffeur)
        {
            if ($chauffeur->aUnTrajetEntre($dateDepart, $dateArriveeApproximatif) === false)
            {
                $chauffeursDisponibles[] = $chauffeur;
            }
        }

        return collect($chauffeursDisponibles);
    }


    /**
     * Recuperer tous les chauffeurs disponibles d'un transporteur en fonction d'une date
     *
     * @param string $date Date et heure de départ du client
     * @param string $dateArriveeApproximatif Date et heure d'arrivee approximatif
     * @return Collection
     */
    /*public function ChauffeurDisponible(string $date, string $dateArriveeApproximatif)
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
    }*/
}
