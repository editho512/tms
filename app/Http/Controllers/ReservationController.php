<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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


    /**
     * Accepter une reservation faite par un client
     *
     * @param Reservation $reservation La reservation concerné
     * @return void
     */
    public function accept(Reservation $reservation)
    {
        if (!$reservation->siblings(true)->isEmpty()) {
            request()->session()->flash("notification", [
                "value" => "La réservation est déja prise par un autre transporteur" ,
                "status" => "error"
            ]);

            return redirect()->back();
        }

        $reservation->status = Reservation::STATUS[1];
        $update = $reservation->update();

        if ($update)
        {
            foreach ($reservation->siblings() as $reservation)
            {
                $reservation->status = Reservation::STATUS[5];
                $update = $reservation->update();
            }
        }

        request()->session()->flash("notification", [
            "value" => "Réservation accepté" , "status" => "success"
        ]);

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
        $transporteurs = $request->transporters;
        $details = $request->reservationDetaisl;

        $departId = intval($details['depart']);
        $arriveeId = intval($details['arrivee']);
        $date_heure = Carbon::parse($details['date_depart'] . ' ' . $details['heure_depart'], 'EAT')->toDateTimeString();

        $reservation = false;
        $numeroReservation = "RES-" . rand(100, 999) . '-' .date('s');

        foreach ($transporteurs as $id => $transporteur)
        {
            $reservation = Reservation::create([
                'numero' => $numeroReservation,
                'depart_id' => $departId,
                'client_id' => auth()->user()->id,
                'arrivee_id' => $arriveeId,
                'transporteur_id' => $id,
                'date' => $date_heure,
                'status' => Reservation::STATUS[0],
            ]);
        }

        if ($reservation)
        {
            return response()->json([
                'redirect' => true,
                'url' => route('client.transport.history'),
            ]);
        }
    }
}
