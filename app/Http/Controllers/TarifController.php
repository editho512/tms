<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Zone;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\CategoriePrix;
use App\Models\ZoneTransporteur;

class TarifController extends Controller
{
     /**
    * Constructeur qui definit les middlewares
    */
    public function __construct()
    {
        $this->middleware('super-admin');
    }

    public function index(){
        $active_tarif_index = true;
        $mes_zones = ZoneTransporteur::where("user_id", auth()->user()->id)->get();

        $zones = Zone::whereNotIn("id", $mes_zones->pluck("zone_id"))->get();

        $categories = Categorie::leftjoin("categorie_prix", "categorie_prix.categorie_id", "=", "categories.id")
                                ->where("categorie_prix.user_id", auth()->user()->id)
                                ->orWhere("categorie_prix.user_id", null)
                                ->get(["categories.id", "categories.nom"]);
                                

        return view("tarif.tarifIndex", compact("active_tarif_index", "mes_zones", "zones", "categories"));
    }

    public function ajouterCategorie(Request $request, Categorie $categorie){
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

    public function ajouter(Request $request){
        $data = $request->all();

        if(isset($data['zone']) === true 
            && isset(Zone::find($data['zone'])->id) === true 
            && ZoneTransporteur::isSetZone($data['zone']) === false 
        ){
            ZoneTransporteur::create(['zone_id' => $data['zone'], 'user_id' => auth()->user()->id]);
            Session::put("notification", ["value" => "Zone de transporteur ajoutée" , "status" => "success" ]);
        }else{
            Session::put("notification", ["value" => "Echec d'ajout" , "status" => "error" ]);

        }

        return redirect()->back();
    }
}
