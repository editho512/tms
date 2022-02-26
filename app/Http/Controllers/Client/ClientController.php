<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Region;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Depart;
use App\Models\DepartCategorie;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Renvoyer la page de recherche pour le client
     *
     * @return View
     */
    public function search()
    {
        if (!auth()->user()->isClient()) {
            return redirect()->route('camion.liste');
        }

        $provinces = Province::orderBy('nom', 'asc')->get();
        $regions = Region::orderBy('nom', 'asc')->get();
        $districts = District::orderBy('nom', 'asc')->get();
        $communes = Commune::orderBy('nom', 'asc')->get();
        $transporteurs = [];

        return view('client.search', [
            'provinces' => $provinces,
            'regions' => $regions,
            'districts' => $districts,
            'communes' => $communes,
            'transporteurs' => $transporteurs,
            'active' => 0,
        ]);
    }


    /**
     * Afficher la listes de tous les historiques de transport d'un client avec ses status
     *
     * @return View
     */
    public function historique() : View
    {
        if (!auth()->user()->isClient()) {
            return redirect()->route('camion.liste');
        }

        return view('client.history', [
            'active' => 1,
        ]);
    }


    public function doSearch(Request $request)
    {
        $type = intval($request->type);
        $id = $request->id;

        if ($type === 0)
        {
            $province = Province::findOrFail($id);
            $regions = $province->regions;

            return [
                'province' => $province,
                'regions' => $regions,
            ];
        }
        elseif ($type === 1)
        {
            $region = Region::findOrFail($id);
            $districts = $region->districts;
            $province = $region->province;

            return [
                'region' => $region,
                'province' => $province,
                'districts' => $districts,
            ];
        }
        elseif ($type === 2)
        {
            $district = District::findOrFail($id);
            $region = $district->region;
            $province = $region->province;
            $communes = $district->communes;

            $regions = $province->regions;

            return [
                'district' => $district,
                'communes' => $communes,
                'province' => $province,
                'region' => $region,

                'regions' => $regions,
            ];
        }
        elseif ($type === 3)
        {
            // Selection de la commune
            $commune = Commune::findOrFail($id);
            $district = $commune->district;
            $region = $district->region;
            $province = $region->province;

            $regions = $province->regions;
            $districts = $region->districts;
            $communes = $district->communes;


            return [
                'commune' => $commune,
                'district' => $district,
                'region' => $region,
                'province' => $province,

                'regions' => $regions,
                'districts' => $districts,
                'communes' => $communes,
            ];
        }
    }


    public function postSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "province-depart" => ['required', 'numeric', 'exists:provinces,id'],
            "region-depart" => ['required', 'numeric', 'exists:regions,id'],
            "district-depart" => ['required', 'numeric', 'exists:districts,id'],
            "commune-depart" => ['required', 'numeric', 'exists:communes,id'],

            "province-arrivee" => ['required', 'numeric', 'exists:provinces,id'],
            "region-arrivee" => ['required', 'numeric', 'exists:regions,id'],
            "district-arrivee" => ['required', 'numeric', 'exists:districts,id'],
            "commune-arrivee" => ['required', 'numeric', 'exists:communes,id'],
            /*"date_depart" => ['required', 'date', 'after_or_equal:' . Carbon::now()->toDateString()],
            "heure_depart" => ['required'],*/
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $districtDepartID = intval($request->get('district-depart'));
        $districtArriveeID = intval($request->get('district-arrivee'));

        $districtDepart = District::findOrFail($districtDepartID);

        $zone = $districtDepart->zones()->first();

        if ($zone === null)
        {
            return response()->json(['error' => 'Aucune transporteur disponible pour ce district']);
        }

        $transporteurs = $zone->transporteurs; // Recuperer tous les transporteurs qui fait cette zone

        /*$depart = $districtDepart->depart;
        dd($depart);*/

        $districtArrivee = District::findOrFail($districtArriveeID);
        $departCategorie = DepartCategorie::where('depart_id', $districtDepart->id)->where('id_district', $districtArrivee->id)->first('categorie_id');

        if ($departCategorie === null)
        {
            return response()->json(['error' => 'Pas de catégorie concerné par ce trajet']);
        }

        $categorie = $departCategorie->categorie;

        $results = [];

        foreach ($transporteurs as $transporteur)
        {
            if ($transporteur->prixCategorie($categorie->id) !== 0)
            {
                $results[] = [
                    'transporteur' => $transporteur,
                    'prix' => $transporteur->prixCategorie($categorie->id),
                ];
            }
        }

        return response()->json($results);
    }

}
