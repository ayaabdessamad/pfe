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
    public function deletePlan($id)
    {
        $plan = Plans::find($id);
        if ($plan) {
            $plan->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Plan deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Plan not found',
            ]);
        }
    }
    public function get_plan_details($id)
    {
        $plan = Plans::find($id);

        if (!$plan) {
            return response()->json([
                'status' => 404,
                'message' => 'Plan not found',
            ]);
        }

        return response()->json([
            'status' => 200,
            'plan' => $plan,
        ]);
    }
    public function update_plan(Request $request, $id)
    {
        $plan = Plans::find($id);
        if ($plan) {
            $plan->nom = $request->input('nom');
            $plan->description = $request->input('description');
            $plan->prix = $request->input('prix');
            $plan->save();
            return response()->json([
                'status' => 200,
                'message' => 'Plan updated successfully',
                'plan' => $plan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Plan not found',
            ]);
        }
    }
    public function add_plan(Request $request)
    {
        $plan = new Plans();
        $plan->nom = $request->nom;
        $plan->description = $request->description;

        $plan->prix = $request->prix;
        $plan->id_service = $request->id_service;
        $plan->image = $request->image;


        $plan->save();

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Plan created successfully',
            'plan' => $plan,
        ]);
    }
}
