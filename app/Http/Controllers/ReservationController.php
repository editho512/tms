<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Camion;
use App\Models\Trajet;
use App\Models\District;
use App\Models\Chauffeur;
use App\Models\Itineraire;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\CategorieDepart;
use Illuminate\Contracts\View\View;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tous les reservations qui concerne ce transporteur
     *
     * @return View
     */
    public function index() : View
    {
        $active_reservation_index = true;
        $user = User::findOrFail(auth()->user()->id);
        $reservations = null;

        $active_reservation_index = true;
        if($user->isAdmin())
        {
            $reservations = $user->reservationsTransporteur;
        }
        else if($user->isClient())
        {
            $reservations = $user->reservations;
        }
        else
        {
            $reservations = Reservation::all();
        }

        return view("reservation.reservationIndex", [
            "active_reservation_index" => $active_reservation_index,
            "reservations" => $reservations,
        ]);
    }


   
    public function accept(Request $request, Reservation $reservation)
    {
        $data = $request->all();

        if( isset($data["camion"]) === true && isset(Camion::find($data["camion"])->id) === true &&
            isset($data["chauffeur"]) === true && isset(Chauffeur::find($data["chauffeur"])->id) === true
            ){
            
             $duree = CategorieDepart::where("province_id", $reservation->depart_id)->where("ville_id", $reservation->arrivee_id)->get();   
            
             $date_arrivee = date("Y-m-d h:i:s", strtotime($reservation->date) + (( intval($duree[0]->delais_approximatif ) * 60) * 60 ));
            
             $trajet = Trajet::create(
                            [
                                "depart" => $reservation->depart->nom ,
                                "arrivee" => $reservation->arrive->nom ,
                                "date_heure_depart" => $reservation->date ,
                                "date_heure_arrivee" => $date_arrivee ,
                                "etat" => Trajet::getEtat(0) ,
                                "camion_id" => $data["camion"] ,
                                "chauffeur_id" => $data["chauffeur"] ,
                            ]
                        );

            Itineraire::create([
                'nom' => $trajet->depart,
                'id_trajet' => $trajet->id,
            ]);

            Itineraire::create([
                'nom' => $trajet->arrivee,
                'id_trajet' => $trajet->id,
            ]);

            $reservation->status = Reservation::STATUS[1];
            $reservation->trajet_id = $trajet->id;
            $reservation->update();
    
            request()->session()->flash("notification", [
                "value" => "Réservation accepté" , "status" => "success"
            ]);
    
        }else{

            request()->session()->flash("notification", [
                "value" => "Echec de l'opération" , "status" => "error"
            ]);
        }
        
        return redirect()->back();
    }


    /**
     * Accepter une reservation faite par un client
     *
     * @param Reservation $reservation La reservation concerné
     * @return void
     */
    public function reject(Reservation $reservation)
    {
        $reservation->status = Reservation::STATUS[4];
        $reservation->update();

        request()->session()->flash("notification", [
            "value" => "Réservation rejetée" , "status" => "success"
        ]);

        return redirect()->back();
    }


    /**
     * Accepter une reservation faite par un client
     *
     * @param Reservation $reservation La reservation concerné
     * @return void
     */
    public function livrer(Reservation $reservation)
    {
        if ($reservation->livrable() === false)
        {
            request()->session()->flash("notification", [
                "value" => "Ne peut livrer la marchandise maintenant" , "status" => "error"
            ]);

            return redirect()->back();
        }

        $reservation->status = Reservation::STATUS[2];
        $reservation->update();

        request()->session()->flash("notification", [
            "value" => "Marchandise livré" , "status" => "success"
        ]);

        return redirect()->back();
    }


    public function reserver(Request $request)
    {
        $departId = intval($request->data['district']['depart']);
        $arriveeId = intval($request->data['district']['arrivee']);
        $transporteur = intval($request->data['transporteur']['id']);
        $depart = $request->data['date_depart'] . ' ' . $request->data['heure_depart'];
        $date_heure = Carbon::parse($depart, 'EAT')->toDateTimeString();

        $reservation = Reservation::create([
            'depart_id' => $departId,
            'client_id' => auth()->user()->id,
            'arrivee_id' => $arriveeId,
            'transporteur_id' => $transporteur,
            'date' => $date_heure,
            'status' => Reservation::STATUS[0],
        ]);

        if ($reservation)
        {
            return response()->json([
                'redirect' => true,
                'url' => route('client.transport.history'),
            ]);
        }
    }

    public function voir(Reservation $reservation){
        $data['depart'] = $reservation->depart->nom;
        $data['arrivee'] = $reservation->arrive->nom;
        $data['client'] = ucwords($reservation->client->name);
        $data['date'] = formatDate($reservation->date);
        $data['camions'] = auth()->user()->CamionDisponible(date("Y-m-d h:i:s", strtotime($reservation->date)));
        $data['chauffeurs'] = auth()->user()->ChauffeurDisponible(date("Y-m-d h:i:s", strtotime($reservation->date)));

        return response()->json($data);
    }


}
