<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Zone;
use App\Models\Depart;
use App\Models\District;
use App\Models\Categorie;
use App\Models\ZoneDistrict;
use Illuminate\Http\Request;
use App\Models\DepartCategorie;
use Illuminate\Support\Facades\Gate;


class ZoneController extends Controller
{
     /**
    * Constructeur qui definit les middlewares
    */
    public function __construct()
    {
        $this->middleware('super-admin');
    }

    public function index()
    {
        // Verifier si l'utilisateur peut acceder au dashboard
        if (!Gate::allows('acceder-dashboard'))
        {
            return redirect()->route('index');
        }

        $zones = Zone::all();

        $districts = District::all();
        $active_zone_index = "active";

        return view("zone.zoneIndex", compact("active_zone_index", "zones", "districts"));
    }



    public function ajouterCategorie(Request $request){
        $data = $request->all();

        if(
            isset($data["depart"]) === true && isset($data["arrive"]) === true && isset($data["categorie"]) &&
            isset(District::find($data["depart"])->id) === true && isset(District::find($data["arrive"])->id) === true && isset(Categorie::find($data["categorie"])->id) === true

            )
        {
            if( DepartCategorie::isSetCategorie($data["depart"], $data["arrive"]) === false){

                $departs = Depart::where("district_id", $data["depart"])->get();

                if(isset($departs[0]->id) === true){
                    $departs = $departs[0];
                }else{
                    $departs = Depart::create(["district_id" => $data["depart"]]);
                }

                DepartCategorie::create(["depart_id" => $departs->id, "id_district" => $data["arrive"], "categorie_id" => $data["categorie"] ]);
                Session::put("notification", ["value" => "Catégorie ajouté" , "status" => "success" ]);


            }else{
                Session::put("notification", ["value" => "Catégorie existe déja" , "status" => "error" ]);

            }

        }

        return redirect()->back();
    }

    public function supprimerCategorie(DepartCategorie $departCategorie){
        $departCategorie->delete();

        Session::put("notification", ["value" => "Catégorie supprimé" , "status" => "success" ]);

        return redirect()->back();
    }

    public function modifierCategorie(Request $request, DepartCategorie $departCategorie){
        $data = $request->all();

        if(
            isset($data["depart"]) === true && isset($data["arrive"]) === true && isset($data["categorie"]) &&
            isset(District::find($data["depart"])->id) === true && isset(District::find($data["arrive"])->id) === true && isset(Categorie::find($data["categorie"])->id) === true

            )
            {


                $departs = Depart::where("district_id", $data["depart"])->get();

                if(isset($departs[0]->id) === true){
                    $departs = $departs[0];
                }else{
                    $departs = Depart::create(["district_id" => $data["depart"]]);
                }

                $dep = DepartCategorie::where("id", $departCategorie->id)->update(["depart_id" => $departs->id, "id_district" => $data["arrive"], "categorie_id" => $data["categorie"] ]);

                Session::put("notification", ["value" => "Catégorie modifiée" , "status" => "success" ]);


        }

        return redirect()->back();
    }


    /**
     * Voir une zone de travail
     *
     * @param Zone $zone
     * @return void
     */
    public function voirZone(Zone $zone)
    {
        $active_zone_index = "active";

        $districts = ZoneDistrict::where('zone_id', $zone->id)->get();

        $itineraires = DepartCategorie::join("departs", "departs.id", "=", "depart_categories.depart_id")
                                        ->join("zone_districts", "zone_districts.district_id", "=", "departs.district_id")
                                        ->where("zone_districts.zone_id", "=", $zone->id)
                                        ->get(['depart_categories.id', "depart_categories.depart_id", "depart_categories.categorie_id", "depart_categories.id_district", "zone_districts.zone_id"]);


        $allDistricts = District::all();

        $categories = Categorie::all();

        return view("zone.voirZone", compact("active_zone_index", "zone", "districts", "itineraires", "allDistricts", "categories"));

    }

    public function trouverItineraire(DepartCategorie $departCategorie){

        return response()->json(["depart" => $departCategorie->depart->district_id,
                                    "arrive" => $departCategorie->district->id,
                                    "categorie" => $departCategorie->categorie->id
                                ]);
    }

    public function supprimer(Zone $zone){

        ZoneDistrict::where("zone_id", $zone->id)->delete();
        $zone->delete();

        Session::put("notification", ["value" => "Zone supprimée" , "status" => "success" ]);

        return redirect()->back();
    }

    public function edit(Zone $zone, Request $request){

        $data = $request->validate([
            "name" => "required" ,
            "district" => "required"
        ]);

        if(count($data['district']) > 0  ){

            Zone::where("id", $zone->id)->update(["name" => $data['name']]);
            ZoneDistrict::where("zone_id", $zone->id)->delete();

            foreach ($data['district'] as $key => $district) {

                if( isset(District::find($district)->id) === true ){
                    ZoneDistrict::create(['zone_id' => $zone->id, "district_id" => $district]);

                    Session::put("notification", ["value" => "Zone modifiée" , "status" => "success" ]);

                }
            }
        }

        return redirect()->back();
    }

    public function modifier(Zone $zone){
        return response()->json(['zone' => $zone, 'district' => $zone->getDistrictId()]);
    }

    public function ajouter(Request $request){
        $data = $request->validate([
            "name" => "required" ,
            "district" => "required"
        ]);

        if(count($data['district']) > 0  ){

            $zone = Zone::create(["name" => $data['name']]);

            foreach ($data['district'] as $key => $district) {

                if( isset(District::find($district)->id) === true ){
                    ZoneDistrict::create(['zone_id' => $zone->id, "district_id" => $district]);

                    Session::put("notification", ["value" => "Zone ajoutée" , "status" => "success" ]);

                }
            }
        }

        return redirect()->back();

    }


}
