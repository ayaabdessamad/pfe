<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Models\Service;
use App\Models\Hotel;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    /* public function bar()
    {
        $userv = ['email' => "", 'nom' => "", 'role' => ""];

        Mail::to('aya@mail.test')->send(new TestEmail($userv));
        return view('welcome');
    }*/
    public function getservices()
    {
        $services = Hotel::with(['services'])->get();
        return response()->json([
            'status' => 200,
            'hotel' => $services,
        ]);
    }
    public function getservicesbyidhotel($id_hotel)
    {
        //var_dump((int)$id);
        $services = Service::where('id_hotel', $id_hotel)->get();
        return response()->json([
            'status' => 200,
            'service' => $services,
        ]);
    }
    /*public function getservicesbyid($id_service)
    {
        //var_dump((int)$id);
        $services = Restaurant::where('id_service', $id_service)->get();
        return response()->json([
            'status' => 200,
            'service' => $services,
        ]);
    }*/
    public function getplatsbyidrestaurant($id_restaurant)
    {
        //var_dump((int)$id);
        $plats = Menu::where('id_restaurant', $id_restaurant)->get();
        return response()->json([
            'status' => 200,
            'plat' => $plats,
        ]);
    }
}
