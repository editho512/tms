<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Session;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('super-admin');
    }

    public function index(){
        $active_reservation_index = true;
        
        $reservations = Reservation::all();

        return view("reservation.reservationIndex", compact("active_reservation_index", "reservations"));
    }

    public function accept(Reservation $reservation){
        $reservation->status = Reservation::STATUS[1];
        $reservation->id_user = auth()->user()->id;
        $reservation->update();

        Session::put("notification", ["value" => "Réservation accepté" , "status" => "success" ]);

        return redirect()->back();

    }

}
