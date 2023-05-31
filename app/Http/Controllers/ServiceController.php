<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $serices = Service::all();
        return response()->json([
            'status' => 200,
            'message' => $serices,
        ]);
    }
    public function store(Request $request)
    {
        $serices = new Service();
        //$serices->id_service = $request->input('id_service');
        $serices->nom = $request->input('nom');
        $serices->description = $request->input('description');
        $serices->image = $request->input('image');
        $serices->type = $request->input('type');
        $serices->id_hotel = $request->input('id_hotel');
        $serices->path = $request->input('path');
        $serices->save();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'services added succesuffly',
        ]);
    }
    public function edit($id)
    {
        $services = Service::find($id);
        return response()->json([
            'status' => 200,
            'service' => $services,
        ]);
    }


    public function update(Request $request, $id)
    {

        $services =  Service::find($id);

        $services->nom = $request->input('nom');
        $services->description = $request->input('description');
        $services->image = $request->input('image');
        $services->type = $request->input('type');
        $services->update();
        return response()->json([
            'status' => 200,
            'message' => 'service updated succesuffly',
        ]);
    }
    public function delete($id)
    {
        $services = Service::find($id);
        $services->delete();
        return response()->json([
            'status' => 200,
            'message' => 'service deleted succesuffly',
        ]);
    }
    //get services by idhotel
    public function getservicesbyidhotel($id_hotel)
    {

        $services = Service::where('id_hotel', $id_hotel)->get();
        return response()->json([
            'status' => 200,
            'service' => $services,
        ]);
    }
    //recherche par nom service
    public function searchServiceByName($hotelId, $nom)
    {
        $services = Service::where('nom', 'like', '%' . $nom . '%')->where('id_hotel', $hotelId)->get();
        return response()->json($services);
    }
    public function getTopService()
    {
        $topRestaurantService = DB::table('services as s')
            ->select('s.nom', 's.image', 'h.nom as nom_hotel', DB::raw('COUNT(DISTINCT c.id) as total_orders'))
            ->join('menu as m', 's.id_service', '=', 'm.id_service')
            ->join('plats as p', 'm.id', '=', 'p.id_menu')
            ->join('commande as c', 'p.id', '=', 'c.id')
            ->join('hotel as h', 's.id_hotel', '=', 'h.id')
            ->where('s.type', '=', 'restaurant')
            ->groupBy('s.id_service')
            ->orderBy('total_orders', 'desc')
            ->limit(1);

        $topSportService = DB::table('services as s')
            ->select('s.nom', 's.image', 'h.nom as nom_hotel', DB::raw('COUNT(DISTINCT ap.id) as total_plans'))
            ->join('plans as tp', 's.id_service', '=', 'tp.id_service')
            ->join('achats_plans as ap', 'tp.id', '=', 'ap.id_plan')
            ->join('hotel as h', 's.id_hotel', '=', 'h.id')
            ->where('s.type', '=', 'salle de sport')
            ->groupBy('s.id_service')
            ->orderBy('total_plans', 'desc')
            ->limit(1);

        $topSpa = DB::table('services as s')
            ->select('s.nom', 's.image', 'h.nom as nom_hotel', DB::raw('COUNT(DISTINCT ap.id) as total_plans'))
            ->join('plans as tp', 's.id_service', '=', 'tp.id_service')
            ->join('achats_plans as ap', 'tp.id', '=', 'ap.id_plan')
            ->join('hotel as h', 's.id_hotel', '=', 'h.id')
            ->where('s.type', '=', 'spa')
            ->groupBy('s.id_service')
            ->orderBy('total_plans', 'desc')
            ->limit(1);

        $result = $topRestaurantService->union($topSportService)->union($topSpa)->get();
        return response()->json($result);
    }
}
