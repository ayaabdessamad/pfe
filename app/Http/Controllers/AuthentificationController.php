<?php

namespace App\Http\Controllers;

use App\Models\AdminHotel;
use App\Models\User;
use App\Models\Hotel;
use App\Mail\TestEmail;
use App\Mail\MonEmail;
use Illuminate\Support\Facades\Event;
use App\Events\RequestClientValidation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthentificationController extends Controller
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
            'role' => 'string',
            'solde' => 'integer',

            'id_hotel' => 'integer',
            'id_service' => 'integer'




        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $defaultValues = [
            'role' => 'client',
            'solde' => 0,
            'id_service' => 0,
            'photo' => 'https://img.freepik.com/vecteurs-libre/mysterieux-personnage-gangster_23-2148466806.jpg?size=626&ext=jpg&ga=GA1.1.1131624615.1675268415&semt=robertav1_2_sidr'
        ];
        $personne = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password), 'statut' => 'non validé'],
            $defaultValues
        ));
        $userv = ['email' => $request->email, 'nom' => $request->nom, 'prénom' => $request->prénom, 'password' => $request->password,  'role' => $request->role];
        Mail::to("abdessamadaya1@gmail.com")->send(new MonEmail($userv));

        Log::alert($personne);
        // \Log::info($personne);

        Event::dispatch(new RequestClientValidation($personne));

        // event(new RequestClientValidation($personne));

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
        // Vérifiez si l'utilisateur a un statut valide ici
        if (Auth::user()->statut !== 'validé') {
            return response()->json(['status' => false, 'error' => 'Votre compte n\'est pas encore validé. Veuillez contacter l\'administrateur.'], 401);
        }

        return

            $this->createNewToken($token);
    }


    public function createNewToken($token)

    {
        $expiresIn = now()->addWeek()->timestamp; // Durée de vie d'une semaine en secondes
        return response()->json([
            'token' => $token,
            'token-type' => 'Bearer',
            'expires_in' => $expiresIn,
            'user' => Auth::guard('api')->user(),
            'status' => true

        ]);
    }
    public function hotelName($id_hotel)
    {
        $hotel = Hotel::find($id_hotel);
        return $hotel ? $hotel->nom : '';
    }
    public function profile()
    {
        $user = Auth::guard('api')->user()->load('hotel');
        return response()->json($user);
    }


    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'user logged out successfully']);
    }
    public function getUser($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
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
