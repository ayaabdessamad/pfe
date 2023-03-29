<?php

namespace App\Http\Controllers;

use App\Models\pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    public function index()
    {
        $pays = pays::all();
        return response()->json([
            'status' => 200,
            'message' => $pays,
        ]);
    }
}
