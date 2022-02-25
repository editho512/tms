<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

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

    /**
    * Afficher la dashboard
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        $user = auth()->user();

        if ($user->isClient())
        {
            return redirect()->route('client.search');
        }

        if ($user->isAdmin())
        {
            return redirect()->route('camion.liste');
        }

        return view('accueil');
    }
}
