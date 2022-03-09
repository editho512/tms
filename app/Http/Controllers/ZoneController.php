<?php

namespace App\Http\Controllers;

use App\Models\Rn;
use App\Models\Zone;
use App\Models\Ville;
use App\Models\Province;
use App\Models\Categorie;
use App\Models\ZoneDistrict;
use Illuminate\Http\Request;
use App\Models\CategorieDepart;
use App\Models\DepartCategorie;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class ZoneController extends Controller
{
    /**
     * Contsructeur qui définit la middleware
     */
    public function __construct()
    {
        $this->middleware('super-admin');
    }

    /**
     * Page d'accueil de la zone
     *
     * @return View
     */
    public function index() : View
    {
        $rns = Rn::all();
        $villes = Ville::all();
        $active_zone_index = "active";

        return view("zone.zoneIndex", compact("active_zone_index", "rns", "villes"));
    }


    public function ajouterCategorie(Request $request)
    {
        $data = $request->validate([
            "depart" => ["required", "numeric", "exists:provinces,id"],
            "arrive" => ["required", "numeric", "exists:villes,id"],
            "categorie" => ["required", "numeric", "exists:categories,id"],
            "delais_approximatif" => ["nullable", "numeric", "min:1", "max:200"],
        ]);

        $categorieDepart = new CategorieDepart([
            "province_id" => $data['depart'],
            "ville_id" => $data['arrive'],
            "categorie_id" => $data['categorie'],
            "delais_approximatif" => $data['delais_approximatif'],
        ]);

        if ($categorieDepart->save())
        {
            $request->session()->flash("notification", [
                "value" => "Catégorie ajouté" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Impossible d'ajouter la catégorie" ,
                "status" => "error"
            ]);
        }

        return redirect()->back();
    }

    public function supprimerCategorie(DepartCategorie $departCategorie)
    {
        $departCategorie->delete();
        Session::put("notification", ["value" => "Catégorie supprimé" , "status" => "success" ]);

        return redirect()->back();
    }

    public function modifierCategorie(Request $request, CategorieDepart $departCategorie)
    {
        $data = $request->validate([
            "depart" => ["required", "numeric", "exists:provinces,id"],
            "arrive" => ["required", "numeric", "exists:villes,id"],
            "categorie" => ["required", "numeric", "exists:categories,id"],
            "delais_approximatif" => ["nullable", "numeric", "min:1", "max:200"],
        ]);

        $update = $departCategorie->update([
            "province_id" => $data['depart'],
            "ville_id" => $data['arrive'],
            "categorie_id" => $data['categorie'],
            "delais_approximatif" => $data['delais_approximatif'],
        ]);

        if ($update)
        {
            $request->session()->flash("notification", [
                "value" => "Catégorie mis a jour" ,
                "status" => "success"
            ]);
        }
        else
        {
            $request->session()->flash("notification", [
                "value" => "Impossible mettre a jour la catégorie" ,
                "status" => "error"
            ]);
        }

        return redirect()->back();
    }

    /**
    * Voir une zone de travail
    *
    * @param int $rnId
    * @return void
    */
    public function voirZone(int $rnID)
    {
        $active_zone_index = "active";
        $rn = Rn::findOrFail($rnID);
        $villes = $rn->villes;
        $categories = Categorie::all();
        $grandeVilles = Province::all();
        $itineraires = CategorieDepart::getAllIn($rnID);

        return view("zone.voirZone", [
            "active_zone_index" => $active_zone_index,
            "rn" => $rn,
            "villes" => $villes,
            "itineraires" => $itineraires,
            "categories" => $categories,
            "grandeVilles" => $grandeVilles
        ]);

    }

    public function trouverItineraire(CategorieDepart $departCategorie)
    {
        return response()->json([
            "depart" => $departCategorie->depart->id,
            "arrive" => $departCategorie->arrivee->id,
            "categorie" => $departCategorie->categorie->id,
            "delais_approximatif" => $departCategorie->delais_approximatif,
        ]);
    }

    public function supprimer(Zone $zone){

        ZoneDistrict::where("zone_id", $zone->id)->delete();
        $zone->delete();

        Session::put("notification", ["value" => "Zone supprimée" , "status" => "success" ]);

        return redirect()->back();
    }

    public function edit(Rn $zone, Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "exists:rns,nom"] ,
            "ville" => ["array"],
        ]);

        $villesActuel = $zone->villes->pluck('id')->toArray();
        $nouvellesVilles = $data['ville'];

        foreach ($villesActuel as $id)
        {
            if (!in_array($id, $nouvellesVilles))
            {
                $zone->villes()->detach($id);
            }
        }

        foreach ($nouvellesVilles as $id)
        {
            if (!in_array($id, $villesActuel))
            {
                $zone->villes()->attach($id);
            }
        }

        $request->session()->flash("notification", [
            "value" => "Zone modifiée" , "status" => "success"
        ]);

        return redirect()->back();
    }

    public function modifier(Rn $zone)
    {
        return response()->json(['rn' => $zone, 'villes' => $zone->villes->pluck('id')]);
    }

    public function ajouter(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "unique:rns,nom"] ,
            "ville" => ["required", "array"],
        ]);

        if (count($data['ville']) > 0)
        {
            $rn = Rn::create([
                "nom" => strtoupper($data['name'])
            ]);

            if ($rn)
            {
                foreach ($data['ville'] as $villeID)
                {
                    $ville = Ville::find($villeID);
                    if ($ville !== null)
                    {
                        $rn->villes()->attach($ville->id);
                    }
                }

                $request->session()->flash("notification", [
                    "value" => "Zone ajoutée" ,
                    "status" => "success"
                ]);
            }
        }
        return redirect()->back();
    }
}
