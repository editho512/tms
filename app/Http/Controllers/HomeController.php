<?php

namespace App\Http\Controllers;

use App\Models\User;
<<<<<<< HEAD
use Illuminate\Contracts\View\View;
=======
>>>>>>> migration
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

<<<<<<< HEAD

    public function main() : View
    {
        $user = auth()->user();

        return view('client.search');
    }

=======
>>>>>>> migration
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
<<<<<<< HEAD
        dd(auth()->user());

=======
>>>>>>> migration
        // Verifier si l'utilisateur peut acceder au dashboard ou non en fonction de son type
        if (!Gate::allows('acceder-dashboard'))
        {
            return redirect()->route('index');
        }

        return redirect()->route('camion.liste');
    }
}
