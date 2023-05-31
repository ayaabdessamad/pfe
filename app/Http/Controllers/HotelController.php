<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    //get all hotels
    public function index()
    {
        $hotels = Hotel::all();

        return response()->json([
            'status' => 200,
            'hotel' => $hotels,

        ]);
    }
    // $users = Personne::Where('role', 'admin')->get();
    //get hotels in monastir
    public function gethotelbylocalisation($localisation)
    {
        //var_dump((int)$id);
        $hotels = Hotel::where('localisation', $localisation)->get();
        return response()->json([
            'status' => 200,
            'hotel' => $hotels,
        ]);
    }
    public function gethotelsM()
    {
        $hotels = Hotel::where('localisation', 'monastir')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in sousse
    public function gethotelsS()
    {
        //validation form request 
        $hotels = Hotel::where('localisation', 'sousse')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in hammamet
    public function gethotelsH()
    {
        $hotels = Hotel::where('localisation', 'hammamet')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in sousse
    public function gethotelsD()
    {
        $hotels = Hotel::where('localisation', 'djerba')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in tunis
    public function gethotelsT()
    {
        $hotels = Hotel::where('localisation', 'tunis')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in mahdia
    public function gethotelsMA()
    {
        $hotels = Hotel::where('localisation', 'mahdia')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in Tozeur
    public function gethotelsTO()
    {
        $hotels = Hotel::where('localisation', 'tozeur')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }
    //get hotels in gammarth
    public function gethotelsG()
    {
        $hotels = Hotel::where('localisation', 'Gammarth')->get();
        return response()->json([
            'status' => 200,
            'message' => $hotels,
        ]);
    }

    public function store(Request $request)
    {
        $hotels = new Hotel();

        $hotels->nom = $request->input('nom');
        $hotels->localisation = $request->input('localisation');
        $hotels->prix = $request->input('prix');

        $hotels->étoiles = $request->input('étoiles');
        $hotels->image = $request->input('image');
        $hotels->description = $request->input('description');
        $hotels->save();
        return response()->json([
            'status' => 200,
            'message' => 'hotels added succesuffly',
            'success' => true
        ]);
    }
    public function edit($id)
    {
        $hotels = Hotel::find($id);
        return response()->json([
            'status' => 200,
            'hotel' => $hotels,
        ]);
    }
    public function update(Request $request, $id)
    {
        // findOrFail
        $hotels =  Hotel::find($id);


        $hotels->nom = $request->input('nom');
        $hotels->localisation = $request->input('localisation');
        $hotels->prix = $request->input('prix');

        $hotels->étoiles = $request->input('étoiles');
        $hotels->image = $request->input('image');
        $hotels->description = $request->input('description');
        $hotels->update();
        return response()->json([
            'status' => 200,
            'message' => 'hotel updated succesuffly',
        ]);
    }
    public function delete($id)
    {
        $hotels = Hotel::find($id);
        $hotels->delete();


        return response()->json([
            'status' => 200,
            'message' => 'hotel deleted succesuffly',
        ]);
    }
    //recherche par nom hotel
    public function searchByName($nom)
    {
        $hotels = Hotel::where('nom', 'like', '%' . $nom . '%')->get();
        return response()->json($hotels);
    }
    public function topHotels(Request $request)
    {
        $hotels = Hotel::join('users', 'hotel.id', '=', 'users.id_hotel')
            ->select('hotel.*', DB::raw('count(users.id) as num_clients_inscrits'))
            ->where('users.role', '=', 'client')
            ->groupBy('hotel.id')
            ->orderByDesc('num_clients_inscrits')
            ->take(4)
            ->get();

        return response()->json($hotels);
    }
}
