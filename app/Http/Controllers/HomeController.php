<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

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
        //Artisan::call('storage:link');
        $user = auth()->user();
        if($user->isClient()){
            return redirect()->route('client.search');
        }else if($user->isAdmin() || $user->estSuperAdmin()){
            return redirect()->route('camion.liste');
        }
        return view('accueil');
    }

}
