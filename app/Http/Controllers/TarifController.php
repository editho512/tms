<?php

namespace App\Http\Controllers;

use App\Models\Rn;
use App\Models\User;
use App\Models\Ville;
use App\Models\Province;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\RnTransporteur;
use App\Models\CategorieDepart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\CategorieRnTransporteur;
use Illuminate\Database\QueryException;
use Session;

class TarifController extends Controller
{
    /**
    * Constructeur qui definit les middlewares
    */
    public function __construct()
    {
        $this->middleware('admin');
    }


    /**
     * Rechercher les trajets en fonction de la route nationale choisi
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function trajetSearch(Request $request) : JsonResponse
    {
        $zone = Rn::findOrFail($request->zone);
        $categorie = Categorie::findOrFail($request->categorie);
        $provinces = Province::all();

        $departCategories = CategorieDepart::whereIn('province_id', $provinces->pluck('id'))->where('categorie_id', $categorie->id)->get();

        $lists = "<ul>";

        foreach ($departCategories as $departCategorie)
        {
            if (in_array($zone->id, $departCategorie->arrivee->zones->pluck('id')->toArray()) AND in_array($zone->id, $departCategorie->depart->zones->pluck('id')->toArray()))
            {
                $lists .= "<li>{$departCategorie->depart->nom} - {$departCategorie->arrivee->nom}</li>";
            }
        }
        $lists .= '</ul>';

        return response()->json([
            'lists' => $lists,
        ]);
    }

    public function index()
    {
        $transporteur = auth()->user();
        $allZones = Rn::all();
        $zones = $transporteur->zones; // Tous les zones où travail le transporteur (RN)
        $active_tarif_index = true;
        $categories = Categorie::all()->take(10);

        $categorieRnTrans = $transporteur->categorieRnTrans; // Informations du prix de trajet du transporteur suivant la catégorie et la RN
        $datas = [];

        $mixte = [];
        $fois = 0;

        foreach ($categorieRnTrans as $categorieRn)
        {
            $zone = $categorieRn->zone;
            $categorie = $categorieRn->categorie;
            $provinces = $zone->provinces;
            $departCategories = CategorieDepart::where('categorie_id', $categorie->id)->get();
            $tmp = [];

            foreach ($departCategories as $d)
            {
                if (in_array($zone->id, $d->arrivee->zones->pluck('id')->toArray()) AND in_array($zone->id, $d->depart->zones->pluck('id')->toArray()))
                {
                    $tmp[] = $d;
                }
                elseif (in_array($zone->id, $d->depart->zones->pluck('id')->toArray()) AND array_intersect($zones->pluck('id')->toArray(), $d->arrivee->zones->pluck('id')->toArray()) !== [] AND array_intersect($d->depart->zones->pluck('id')->toArray(), $d->arrivee->zones->pluck('id')->toArray()) === [])
                {
                    $mixte["MIXTE"][$d->categorie->nom .'-'. $categorieRn->prix][] = [
                        'libelle' => $d->depart->nom . ' - ' . $d->arrivee->nom
                    ];

                    /*$mixte["MIXTE"][$d->categorie->id][] = [
                        'nom' => $d->categorie->nom,
                        'prix' => $categorieRn->prix,
                        'data' => $d->depart->nom . ' - ' . $d->arrivee->nom,
                    ];*/
                }
            }

            if ($tmp !== [])
            {
                $datas[$zone->nom][$categorie->id] = [
                    'nom' => $categorie->nom,
                    'prix' => $categorieRn->prix,
                    'data' => collect($tmp),
                ];
            }

        }

        return view("tarif.tarifIndex", [
            "active_tarif_index" => $active_tarif_index,
            "zones" => $zones,
            "allZones" => $allZones,
            "categories" => $categories,
            'categorieRnTrans' => $categorieRnTrans,
            'datas' => $datas,
            'mixte' => $mixte,
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

    public function supprimer(Rn $ZoneTransporteur){

        RnTransporteur::where("rn_id", $ZoneTransporteur->id)->where("user_id", auth()->user()->id)->delete();
        
        Session::put("notification", ["value" => "Zone de transporteur supprimée" , "status" => "success" ]);

        return redirect()->back();
    }

    public function modifier(Rn $ZoneTransporteur){

        return response()->json(["name" => $ZoneTransporteur->nom]);
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

        if ($transporteur->zones->contains($data['zone']))
        {
            $request->session()->flash("notification", [
                "value" => "Ce zone existe déja dans votre liste actif" ,
                "status" => "error"
            ]);
        }
        else
        {
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
        }

        return redirect()->back();
    }


    public function enregistrerTarif(Request $request)
    {
        $data = $request->validate([
            "zone" => ["required", "numeric", "exists:rns,id"],
            "categorie" => ["required", "numeric", "exists:categories,id"],
            "prix" => ["required", "numeric", "min:1", "max:999999999"],
        ]);

        $categRnTrans = CategorieRnTransporteur::create([
            'transporteur_id' => auth()->user()->id,
            'rn_id' => $data['zone'],
            'categorie_id' => $data['categorie'],
            'prix' => doubleval($data['prix']),
        ]);

        if ($categRnTrans)
        {
            $request->session()->flash("notification", [
                "value" => "Catégorie enregistré avec success" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Erreur d'ajout" ,
                "status" => "error"
            ]);
        }

        return redirect()->back();
    }
}

/*$zone = $zones[0];
$provinces = $zone->provinces;
$departCategories = CategorieDepart::whereIn('province_id', $provinces->pluck('id'))->get();
$trajets = [];
foreach ($departCategories as $departCategorie)
{
    $trajets[] = $departCategorie->depart->nom . ' - ' . $departCategorie->arrivee->nom;
}*/
