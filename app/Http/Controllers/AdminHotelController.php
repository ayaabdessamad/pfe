<?php

namespace App\Http\Controllers;

use App\Models\AdminHotel;
use App\Models\User;
use Hotel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminHotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'photo' => 'string',
            'email' => 'required|string|email|unique:personne',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'solde' => 'integer',
            'statut' => 'string',
            'id_hotel' => 'integer',
            'id_service' => 'integer'




        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $personne = User::create(array_merge($validator->validated(), ['password' => bcrypt($request->password)]));
        return response()->json(['message' => 'user successfuly registered', 'user' => $personne], 201);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'role' => 'string',
            'id_hotel' => 'integer'

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, $validator->errors(), 400]);
        }

        if (!$token = Auth::guard('api')->attempt($validator->validated())) {
            return response()->json(['status' => false, 'error' => 'Unauthorized'], 401);
        }
        return

            $this->createNewToken($token);
    }
    public function createNewToken($token)
    {
        return response()->json([
            'token' => $token,
            'token-type' => 'Bearer',
            //'expires_in' => Auth::guard('web')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user(),
            'status' => true

        ]);
    }
    public function profile()
    {
        return response()->json(Auth::guard('api')->user());
    }
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'user logged out successfully']);
    }
    //get all users
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 200,
            'message' => $users,
        ]);
    }
}
