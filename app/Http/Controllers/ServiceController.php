<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

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
    public function searchByName($nom)
    {
        $services = Service::where('nom', 'like', '%' . $nom . '%')->get();
        return response()->json($services);
    }
}
