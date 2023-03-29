<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Plans;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function getplansbyidservice($id_service)
    {

        $plans = Plans::where('id_service', $id_service)->get();
        return response()->json([
            'status' => 200,
            'plans' => $plans,
        ]);
    }
}
