<?php

namespace App\Http\Controllers\Client;

use App\Models\Region;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    public function search()
    {
        $provinces = Province::orderBy('nom', 'asc')->get();
        $regions = Region::orderBy('nom', 'asc')->get();
        $districts = District::orderBy('nom', 'asc')->get();
        $communes = Commune::orderBy('nom', 'asc')->get();

        return view('client.search', [
            'provinces' => $provinces,
            'regions' => $regions,
            'districts' => $districts,
            'communes' => $communes,
        ]);
    }


    public function doSearch(Request $request)
    {
        $type = intval($request->type);
        $id = $request->id;


        if ($type === 0)
        {
            $province = Province::findOrFail($id);
            $regions = $province->regions;

            return [
                'province' => $province,
                'regions' => $regions,
            ];
        }
        elseif ($type === 1)
        {
            $region = Region::findOrFail($id);
            $districts = $region->districts;
            $province = $region->province;

            return [
                'region' => $region,
                'province' => $province,
                'districts' => $districts,
            ];
        }
        elseif ($type === 2)
        {
            $district = District::findOrFail($id);
            $region = $district->region;
            $province = $region->province;
            $communes = $district->communes;

            return [
                'district' => $district,
                'communes' => $communes,
                'province' => $province,
                'region' => $region,
            ];
        }
        elseif ($type === 3)
        {
            // Selection de la commune
            $commune = Commune::findOrFail($id);
            $district = $commune->district;
            $region = $district->region;
            $province = $region->province;

            $regions = $province->regions;
            $districts = $region->districts;
            $communes = $district->communes;


            return [
                'commune' => $commune,
                'district' => $district,
                'region' => $region,
                'province' => $province,

                'regions' => $regions,
                'districts' => $districts,
                'communes' => $communes,
            ];
        }
    }

}
