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
    public function delete_plat($id)
    {
        $plat = Plat::find($id);
        if ($plat) {
            $plat->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Plat deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Plat not found',
            ]);
        }
    }
    public function get_plat_details($id)
    {
        $plat = Plat::find($id);

        if (!$plat) {
            return response()->json([
                'status' => 404,
                'message' => 'Plat not found',
            ]);
        }

        return response()->json([
            'status' => 200,
            'plat' => $plat,
        ]);
    }

    public function update_plat(Request $request, $id)
    {
        $plat = Plat::find($id);
        if ($plat) {
            $plat->nom = $request->input('nom');
            $plat->description = $request->input('description');
            $plat->prix = $request->input('prix');
            $plat->save();
            return response()->json([
                'status' => 200,
                'message' => 'Plat updated successfully',
                'plat' => $plat
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Plat not found',
            ]);
        }
    }
    public function add_plat(Request $request)
    {
        $plat = new Plat();
        $plat->nom = $request->nom;
        $plat->description = $request->description;
        $plat->categorie = $request->categorie;
        $plat->prix = $request->prix;
        $plat->id_menu = $request->id_menu;
        $plat->image = $request->image;


        $plat->save();

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Plat created successfully',
            'plat' => $plat,
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
}
