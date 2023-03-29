<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //get services by idhotel
    public function getmenubyidservice($id_service)
    {

        $menus = Menu::where('id_service', $id_service)->get();
        return response()->json([
            'status' => 200,
            'menu' => $menus,
        ]);
    }
}
