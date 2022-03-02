<?php

namespace App\Http\Controllers;

use App\Models\Rn;
use App\Models\User;
use App\Models\Categorie;
use App\Models\CategorieDepart;
use App\Models\CategorieRnTransporteur;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TarifController extends Controller
{
    /**
    * Constructeur qui definit les middlewares
    */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function trajetSearch(Request $request)
    {
        $zone = Rn::findOrFail($request->id);
        $provinces = $zone->provinces;

        $departCategories = CategorieDepart::whereIn('province_id', $provinces->pluck('id'))->get();
        //$trajets = [];

        $options = '';

        foreach ($departCategories as $departCategorie)
        {
            //$trajets[] = $departCategorie->depart->nom . ' - ' . $departCategorie->arrivee->nom;
            $options .= "<option value='{$departCategorie->depart->id}-{$departCategorie->arrivee->id}'>{$departCategorie->depart->nom} - {$departCategorie->arrivee->nom}</option>\n";
        }

        return response()->json(['options' => $options]);
    }

    public function index()
    {
        $transporteur = auth()->user();
        $allZones = Rn::all();
        $zones = $transporteur->zones; // Tous les zones où travail le transporteur (RN)
        $active_tarif_index = true;
        $categories = Categorie::all()->take(10);

        /*$zone = $zones[0];
        $provinces = $zone->provinces;

        $departCategories = CategorieDepart::whereIn('province_id', $provinces->pluck('id'))->get();
        $trajets = [];

        foreach ($departCategories as $departCategorie)
        {
            $trajets[] = $departCategorie->depart->nom . ' - ' . $departCategorie->arrivee->nom;
        }*/

        return view("tarif.tarifIndex", [
            "active_tarif_index" => $active_tarif_index,
            "zones" => $zones,
            "allZones" => $allZones,
            "categories" => $categories,
        ]);
    }

    public function ajouterCategorie(Request $request, Categorie $categorie)
    {
        dd($request->all());
        $data = $request->all();
        if(isset($data["montant"]) === true && doubleval($data["montant"]) >= 0){
            CategoriePrix::where("categorie_id", $categorie->id)->where("user_id", auth()->user()->id)->delete();

            CategoriePrix::create(["categorie_id" => $categorie->id, "montant" => $data["montant"], "user_id" => auth()->user()->id ]);

            Session::put("notification", ["value" => "Montant ajouté" , "status" => "success" ]);

        }else{
            Session::put("notification", ["value" => "echec d'ajout" , "status" => "error" ]);

        }

        return redirect()->back();
    }

    public function trouverCategorie(Categorie $categorie){
        return response()->json(["categorie" => $categorie, "montant" => $categorie->prix()]);
    }

    public function voirZoneTransporteur(ZoneTransporteur $ZoneTransporteur){
        dd($ZoneTransporteur);
    }

    public function supprimer(ZoneTransporteur $ZoneTransporteur){
        $ZoneTransporteur->delete();

        Session::put("notification", ["value" => "Zone de transporteur supprimée" , "status" => "success" ]);

        return redirect()->back();
    }

    public function modifier(ZoneTransporteur $ZoneTransporteur){

        return response()->json(["name" => $ZoneTransporteur->zone()->name]);
    }


    /**
     * Ajouter un nouveau zone de travail pour un transporteur
     *
     * @param Request $request Requete contenant tous les champs
     * @return RedirectResponse
     */
    public function ajouter(Request $request) : RedirectResponse
    {
        $data = $request->validate([
            "zone" => ["required", "exists:rns,id"],
        ]);

        $transporteur = auth()->user();

        try {
            $transporteur->zones()->attach($data['zone']);
            $request->session()->flash("notification", [
                "value" => "Zone de transporteur ajoutée" ,
                "status" => "success"
            ]);
        }
        catch (QueryException $e){
            $request->session()->flash("notification", [
                "value" => "Erreur de requete sal : {$e->getMessage()}" ,
                "status" => "error"
            ]);
        }

        return redirect()->back();
    }


    public function enregistrerTarif(Request $request)
    {
        $data = $request->validate([
            "zone" => ["required", "numeric", "exists:rns,id"],
            "trajet" => ["required", "sometimes"],
            "prix" => ["required", "numeric", "min:1", "max:999999999"],
        ]);

        $trajets = explode('-', $data['trajet']);
        $departID = intval($trajets[0]);
        $arriveeID = intval(end($trajets));
        $categorie_id = CategorieDepart::where('province_id', $departID)->where('ville_id', $arriveeID)->first('categorie_id')->categorie_id;

        $categRnTrans = CategorieRnTransporteur::create([
            'transporteur_id' => auth()->user()->id,
            'rn_id' => $data['zone'],
            'categorie_id' => $categorie_id,
        ]);
    }
}
