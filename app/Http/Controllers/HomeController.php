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


    public function main() : RedirectResponse
    {
        $user = auth()->user();

        return redirect()->route('client.search');
    }

    /**
    * Show the application dashboard.
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

        // Verifier si l'utilisateur peut acceder au dashboard ou non en fonction de son type
        if (!Gate::allows('acceder-dashboard'))
        {
            return redirect()->route('index');
        }

        return redirect()->route('camion.liste');
    }
}
