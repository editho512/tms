<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ville;
use App\Models\Region;
use App\Models\Province;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\RnTransporteur;
use App\Models\CategorieDepart;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
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
        //dd(Hash::make('Passw0rd.2022'));
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

        $reservations = auth()->user()->reservations()->where('status', '<>', Reservation::STATUS[5])->get();

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

        $departIDS = $zonesDepart->pluck('id')->toArray();
        $arriveeIDS = $zonesArrivee->pluck('id')->toArray();

        if ($zonesDepart === Collection::empty() OR $zonesArrivee === Collection::empty())
        {
            return response()->json(['error' => 'Aucune transporteur disponible pour ce district']);
        }

        $zoneTransporteurs = null;
        $ids = array_intersect($departIDS, $arriveeIDS);

        if ($ids === [])
        {
            $zoneTransporteurs = RnTransporteur::whereIn('rn_id', $zonesDepart->pluck('id'))->orWhereIn('rn_id', $zonesArrivee->pluck('id'))->get(); // Si le transporteur travail sur la rn de depart et la rn d'arrivée
        }
        else
        {
            $zoneTransporteurs = RnTransporteur::whereIn('rn_id', $ids)->get();
        }

        //$zoneTransporteurs = RnTransporteur::whereIn('rn_id', $zonesDepart->pluck('id'))->orWhereIn('rn_id', $zonesArrivee->pluck('id'))->get();
        $departCategorie = CategorieDepart::where('province_id', $villeDepart->id)->where('ville_id', $villeArrivee->id)->first('categorie_id');

        if ($departCategorie === null)
        {
            return response()->json(['error' => 'Pas de catégorie concerné par ce trajet']);
        }

        $categorie = $departCategorie->categorie;
        $dateHeureDepart = Carbon::parse($request->date_depart . ' ' . $request->heure_depart)->toDateTimeString();
        $results = [];

        foreach ($zoneTransporteurs as $zone)
        {
            $transporteur = User::find($zone->user_id);

            if (!$transporteur->CamionDisponible($dateHeureDepart)->isEmpty() AND !$transporteur->ChauffeurDisponible($dateHeureDepart)->isEmpty())
            {
                if ($transporteur->prixCategorie($categorie->id, $zone->rn_id) !== 0)
                {
                    $results[] = [
                        'transporteur' => $transporteur,
                        'prix' => number_format($transporteur->prixCategorie($categorie->id, $zone->rn_id), 2, ",", " "),
                        'depart' => $villeDepartID,
                        'date_depart' => $request->date_depart,
                        'heure_depart' => $request->heure_depart,
                        'villes' => [
                            'depart' => $villeDepartID,
                            'arrivee' => $villeArriveeID,
                        ],
                    ];
                }
            }
        }

        $tmp = [];
        if ($results !== [])
        {
            $tmp['results'] = $results;
            $tmp['details'] = [
                'depart' => $villeDepartID,
                'date_depart' => $request->date_depart,
                'heure_depart' => $request->heure_depart,
                'arrivee' => $villeArriveeID,
            ];
        }

        return response()->json($tmp);
    }


    public function annulerReservation(Reservation $reservation)
    {
        $reservation->status = Reservation::STATUS[3];
        $reservation->update();

        return redirect()->back();
    }

}
