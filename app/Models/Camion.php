<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'annee', 'model', 'marque', 'numero_chassis', 'photo', 'user_id',
    ];

    public function CarburantRestant(){
        $stock =  Carburant::where("camion_id", "=", $this->id)->groupBy("flux")->selectRaw("sum(quantite) as quantite, flux")->get();
        $stock = $stock->toArray();
        $entre = 0 ;
        $sortie = 0;

        foreach ($stock as $key => $value) {
            # code...
            if($value["flux"] == 0){
                $entre = doubleval($value["quantite"]);
            }else{
                $sortie = doubleval($value["quantite"]);
            }
        }

        return (doubleval($entre) - doubleval($sortie));
    }

    public function estDispoEntre(Carbon $date_depart, Carbon $date_arrivee, $trajet = null){

        $depart = Trajet::where("camion_id", $this->id)
                ->where("date_heure_depart", ">=", $date_depart->toDateTimeString() )
                ->where("date_heure_depart", "<=", $date_arrivee->toDateTimeString());
    
        $arrivee = Trajet::where("camion_id", $this->id)
                ->where("date_heure_arrivee", ">=", $date_depart->toDateTimeString() )
                ->where("date_heure_arrivee", "<=", $date_arrivee->toDateTimeString());

        if($trajet != null){
            $depart = $depart->where("id", "!=", $trajet->id);
            $arrivee = $arrivee->where("id", "!=", $trajet->id);
        }

        $depart = $depart->get(); 
        $arrivee = $arrivee->get();                  
        return !isset($depart[0]->id) && !isset($arrivee[0]->id);
    }

    public function transporteur(){
        return $this->hasOne(User::class, "id", "user_id");
    }

    /**
    * Méthode qui retourne tous les trajets faite par un camion
    *
    * @return  HasMany Relation une a plusieurs (Un camion a fait un ou plusieurs trajets)
    */
    public function trajets() : HasMany
    {
        return $this->hasMany(Trajet::class, 'camion_id', 'id');
    }


    /**
    * [dernierTrajet description]
    *
    * @return  Trajet  [return description]
    */
    public function dernierTrajet(bool $enCours = false)
    {
        if ($enCours === true)
        {
            return $this->trajets()->orderBy('id', 'desc')->where('etat', Trajet::getEtat(1))->first();
        }
        return $this->trajets()->orderBy('id', 'desc')->first();
    }


    /**
    * Determiner si le camion a un trajet en cours d'execution
    * Condition: Si le dernier trajet en cours du camion est null, donc tous ses trajets sont terminé
    * Le camion est donc de nouveau disponible
    *
    * @return  bool  Oui si a un trajet en cours, non sinon
    */
    public function aUnTrajetEnCours(Trajet $trajet = null) : bool
    {
        $trajetEnCours = $this->dernierTrajet(true);

        if ($trajetEnCours !== null)
        {
            if ($trajet !== null AND $trajet->id === $trajetEnCours->id)
            {
                return false;
            }
            return true;
        }
        return false;
    }


    /**
    * Recuperer tous les carburants consommé par un camion
    *
    * @return HasMany
    */
    public function carburants() : HasMany
    {
        return $this->hasMany(Carburant::class);
    }

    public function aUnTrajetEntre(Carbon $depart, ?Carbon $arrivee)
    {
        $trajets = $this->trajets()->where('date_heure_depart');
        dd($trajets);
    }


    public function nombreTrajetEnAttente() : int
    {
        return $this->trajets()->where('etat', Trajet::getEtat(0))->count();
    }


    /**
     * Permet de calculer le stock de carburant d'un camion
     *
     * @return integer
     */
    public function stockCarburant() : int
    {
        return $this->carburants()->where('flux', 0)->sum('quantite') - $this->carburants()->where('flux', 1)->sum('quantite');
    }
}
