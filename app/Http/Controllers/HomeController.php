<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
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


    public function main()
    {
        $user = auth()->user();

        return redirect()->route('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Verifier si l'utilisateur peut acceder au dashboard ou non en fonction de son type
        if (!Gate::allows('acceder-dashboard'))
        {
            return redirect()->route('index');
        }

        return redirect()->route('camion.liste');
    }
}
