<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Region;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\CategorieDepart;
use App\Models\Reservation;
use App\Models\RnTransporteur;
use App\Models\Ville;
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
        $villes = Ville::orderBy('nom', 'asc')->get();
        $transporteurs = [];

        return view('client.search', [
            'provinces' => $provinces,
            'regions' => $regions,
            'villes' => $villes,
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

        if ($type === 1)
        {
            $region = Region::findOrFail($id);
            $villes = $region->villes;

            return [
                'region' => $region,
                'villes' => $villes,
            ];
        }
        elseif ($type === 2)
        {
            $ville = Ville::findOrFail($id);
            $region = $ville->region;
            $regions = Region::orderBy('nom', 'asc')->get();

            return [
                'ville' => $ville,
                'region' => $region,
                'regions' => $regions,
            ];
        }
    }


    public function postSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "province-depart" => ['required', 'numeric', 'exists:provinces,id'],
            "region-arrivee" => ['required', 'numeric', 'exists:regions,id'],
            "ville-arrivee" => ['required', 'numeric', 'exists:villes,id'],
            "date_depart" => ['required', 'date', 'after_or_equal:' . Carbon::now()->toDateString()],
            "heure_depart" => ['required'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $villeDepartID = intval($request->get('province-depart'));
        $villeArriveeID = intval($request->get('ville-arrivee'));

        $villeDepart = Province::findOrFail($villeDepartID);
        $villeArrivee = Ville::findOrFail($villeArriveeID);

        $zonesDepart = $villeDepart->zones;
        $zonesArrivee = $villeArrivee->zones;

        if ($zonesDepart === Collection::empty() OR $zonesArrivee === Collection::empty())
        {
            return response()->json(['error' => 'Aucune transporteur disponible pour ce district']);
        }

        $zoneTransporteurs = RnTransporteur::whereIn('rn_id', $zonesDepart->pluck('id'))->whereIn('rn_id', $zonesArrivee->pluck('id'))->get();
        $departCategorie = CategorieDepart::where('province_id', $villeDepart->id)->where('ville_id', $villeArrivee->id)->first('categorie_id');

        if ($departCategorie === null)
        {
            return response()->json(['error' => 'Pas de catégorie concerné par ce trajet']);
        }

        $categorie = $departCategorie->categorie;
        $results = [];

        foreach ($zoneTransporteurs as $zone)
        {
            $transporteur = User::find($zone->user_id);

            if ($transporteur->prixCategorie($categorie->id, $zone->rn_id) !== 0)
            {
                $results[] = [
                    'transporteur' => $transporteur,
                    'prix' => $transporteur->prixCategorie($categorie->id, $zone->rn_id),
                    'depart' => $villeDepartID,
                    'date_depart' => $request->date_depart,
                    'heure_depart' => $request->heure_depart,
                    'district' => [
                        'depart' => $villeDepartID,
                        'arrivee' => $villeArriveeID,
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