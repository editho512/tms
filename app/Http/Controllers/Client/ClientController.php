<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Region;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\DepartCategorie;
use App\Models\ZoneTransporteur;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
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
        $reservations = auth()->user()->reservations;

        return view('client.history', [
            'active' => 1,
            'reservations' => $reservations,
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
            "date_depart" => ['required', 'date', 'after_or_equal:' . Carbon::now()->toDateString()],
            "heure_depart" => ['required'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $districtDepartID = intval($request->get('district-depart'));
        $districtArriveeID = intval($request->get('district-arrivee'));

        $districtDepart = District::findOrFail($districtDepartID);
        $districtArrivee = District::findOrFail($districtArriveeID);

        $zonesDepart = $districtDepart->zones;
        $zonesArrivee = $districtArrivee->zones;

        if ($zonesDepart === Collection::empty() OR $zonesArrivee === Collection::empty())
        {
            return response()->json(['error' => 'Aucune transporteur disponible pour ce district']);
        }

        $zoneTransporteurs = ZoneTransporteur::whereIn('zone_id', $zonesDepart->pluck('id'))->whereIn('zone_id', $zonesArrivee->pluck('id'))->get();

        $departCategorie = DepartCategorie::where('depart_id', $districtDepart->id)->where('id_district', $districtArrivee->id)->first('categorie_id');

        if ($departCategorie === null)
        {
            return response()->json(['error' => 'Pas de catégorie concerné par ce trajet']);
        }

        $categorie = $departCategorie->categorie;

        $results = [];

        foreach ($zoneTransporteurs as $zone)
        {
            $transporteur = User::find($zone->user_id);

            if ($transporteur->prixCategorie($categorie->id) !== 0)
            {
                $results[] = [
                    'transporteur' => $transporteur,
                    'prix' => $transporteur->prixCategorie($categorie->id),
                    'depart' => $districtDepartID,
                    'date_depart' => $request->date_depart,
                    'heure_depart' => $request->heure_depart,
                    'district' => [
                        'depart' => $districtDepartID,
                        'arrivee' => $districtArriveeID,
                    ],
                ];
            }
        }

        return response()->json($results);
    }


    public function annulerReservation(Reservation $reservation)
    {
        $reservation->status = Reservation::STATUS[3];
        $reservation->update();

        return redirect()->back();
    }

}
