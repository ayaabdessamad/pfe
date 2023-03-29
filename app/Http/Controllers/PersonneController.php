<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Personne;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class PersonneController extends Controller
{

    //get all users
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 200,
            'users' => $users,
        ]);
    }
    //get all clients
    public function getclients()
    {
        $users = User::Where('role', 'client')->get();
        return response()->json([
            'status' => 200,
            'users' => $users,
        ]);
    }
    //get all admins
    public function getadmins()
    {
        $users = User::Where('role', 'admin-hotel')->get();
        return response()->json([
            'status' => 200,
            'message' => $users,
        ]);
    }
    //get all admins
    public function getadmins_Service()
    {
        $users = User::Where('role', 'admin_service')->get();
        return response()->json([
            'status' => 200,
            'message' => $users,
        ]);
    }
    //add admins 
    public function store(Request $request)
    {
        $users = new User();
        $users->id = $request->input('id');
        $users->nom = $request->input('nom');
        $users->prenom = $request->input('prenom');
        $users->photo = $request->input('photo');
        $users->email = $request->input('email');

        $users->password = bcrypt($request->password);
        $users->role = 'admin-hotel';
        $users->statut = ' validé';
        $users->solde = 0;
        $users->id_hotel = $request->input('id_hotel');
        $users->id_service = 0;
        $users->save();
        // $userv = ['email' => $request->email, 'nom' => $request->nom, 'prénom' => $request->prénom, 'role' => $request->role];
        // Mail::to('test@mail.test')->send(new TestEmail($userv));

        return response()->json([
            'status' => 200,
            'message' => 'users added succesuffly',
        ]);
    }
    //add admins 
    public function add_admin_service(Request $request)
    {
        $users = new User();
        $users->id = $request->input('id');
        $users->nom = $request->input('nom');
        $users->prenom = $request->input('prenom');
        $users->photo = $request->input('photo');
        $users->email = $request->input('email');

        $users->password = bcrypt($request->password);
        $users->role = 'admin_service';
        $users->statut = ' validé';
        $users->solde = 0;
        $users->id_hotel = $request->input('id_hotel');
        $users->id_service =  $request->input('id_service');
        $users->save();
        // $userv = ['email' => $request->email, 'nom' => $request->nom, 'prénom' => $request->prénom, 'role' => $request->role];
        // Mail::to('test@mail.test')->send(new TestEmail($userv));

        return response()->json([
            'status' => 200,
            'message' => 'users added succesuffly',
        ]);
    }
    public function edit($id)
    {
        $users = User::find($id);
        return response()->json([
            'status' => 200,
            'user' => $users,
        ]);
    }
    public function update(Request $request, $id)
    {

        $users =  User::find($id);

        $users->id = $request->input('id');
        $users->nom = $request->input('nom');
        $users->prenom = $request->input('prenom');
        $users->photo = $request->input('photo');
        $users->email = $request->input('email');

        //$users->password = bcrypt($request->password);
        $users->role = $request->input('role');
        $users->statut = $request->input('statut');
        $users->solde = $request->input('solde');
        $users->update();
        return response()->json([
            'status' => 200,
            'message' => 'user updated succesuffly',
        ]);
    }
    public function update_admin(Request $request, $id)
    {

        $users =  User::find($id);

        $users->id = $request->input('id');
        $users->nom = $request->input('nom');
        $users->prenom = $request->input('prenom');
        $users->photo = $request->input('photo');
        $users->email = $request->input('email');

        //$users->password = bcrypt($request->password);
        $users->role = $request->input('role');
        $users->statut = $request->input('statut');

        $users->update();
        return response()->json([
            'status' => 200,
            'message' => 'user updated succesuffly',
        ]);
    }
    public function delete($id)
    {
        $users = User::find($id);
        $users->delete();
        return response()->json([
            'status' => 200,
            'message' => 'user deleted succesuffly',
        ]);
    }
    public function valider(Request $request, $id)
    {

        $users =  User::find($id);

        $users->statut = 'validé';
        $users->update();
        return response()->json([
            'status' => 200,
            'message' => 'user validé succesuffly',
        ]);
    }
    public function desactiver(Request $request, $id)
    {

        $users =  User::find($id);

        $users->statut = 'désactivé';
        $users->update();
        return response()->json([
            'status' => 200,
            'message' => 'user désactivé succesuffly',
        ]);
    }
    //recherche par nom hotel
    public function searchByName($nom)
    {
        $users = User::where('nom', 'like', '%' . $nom . '%')->get();
        return response()->json($users);
    }
    ////////////// les historiques 
    // Fonction pour récupérer l'historique des achats pour un hôtel spécifique
    public function getHistoriqueByHotelId($id_hotel)
    {

        // récupérer l'historique associé à l'ID de l'hôtel
        $historique = DB::table('historique')
            ->join('users', 'historique.id_user', '=', 'users.id')
            ->join('services', 'historique.id_service', '=', 'services.id_service')
            ->where('users.id_hotel', $id_hotel)
            ->select('historique.*', 'users.nom as nom_client', 'services.nom as nom_service')
            ->get();

        // renvoyer l'historique en tant que réponse JSON
        return response()->json(['historique' => $historique]);
    }
}
