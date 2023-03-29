<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;

class PlatsController extends Controller
{
    //
    //get plats by idmenu
    public function get_plat_by_idmenu($id_menu)
    {

        $plats = Plat::where('id_menu', $id_menu)->get()->groupBy('categorie');
        return response()->json([
            'status' => 200,
            'plat' => $plats,
        ]);
    }
    public function get_plat_by_idmenu_type($id_menu, $categorie)
    {

        $plats = Plat::where('id_menu', $id_menu)->get()->groupBy('categorie');
        return response()->json([
            'status' => 200,
            'plat' => $plats,
        ]);
    }
    // get categories by id menu
    public function get_categorie_by_idmenu($id_menu)
    {

        $categories = Plat::where('id_menu', $id_menu)->get(['categorie']);
        return response()->json([
            'status' => 200,
            'categorie' => $categories,
        ]);
    }
}
