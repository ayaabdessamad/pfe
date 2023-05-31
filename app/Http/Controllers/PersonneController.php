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
    //get all clients selon id hotel
    public function getClients($hotelId)
    {
        $users = User::where('role', 'client')
            ->where('id_hotel', $hotelId)
            ->get();

        return response()->json([
            'status' => 200,
            'users' => $users,
        ]);
    }
    //get all admins hotel
    public function getadmins()
    {
        $users = User::Where('role', 'admin-hotel')->get();
        return response()->json([
            'status' => 200,
            'message' => $users,
        ]);
    }
    //get all admins service selon id_hotel
    public function getadmins_Service($hotelId)
    {
        $users = User::Where('role', 'admin_service')->where('id_hotel', $hotelId)->get();
        return response()->json([
            'status' => 200,
            'message' => $users,
        ]);
    }
    //add admins hotel
    public function store(Request $request)

    {
        // Vérifier si l'adresse email est déjà utilisée
        $existingUser = User::where('email', $request->input('email'))->first();

        if ($existingUser) {
            return response()->json([
                'status' => 400,
                'message' => 'Cette adresse email est déjà utilisée.',
                'success' => false
            ]);
        }
        $users = new User();
        $users->id = $request->input('id');
        $users->nom = $request->input('nom');
        $users->prenom = $request->input('prenom');
        $users->photo = $request->input('photo');
        $users->email = $request->input('email');

        $users->password = bcrypt($request->password);
        $users->role = 'admin-hotel';
        $users->statut = 'validé';
        $users->solde = 0;
        $users->id_hotel = $request->input('id_hotel');
        $users->id_service = 0;
        $users->save();
        $userv = ['email' => $request->email, 'password' => $request->password, 'nom' => $request->nom, 'prénom' => $request->prénom, 'role' => $request->role];
        Mail::to($users->email)->send(new TestEmail($userv));

        return response()->json([
            'status' => 200,
            'message' => 'users added succesuffly',
            'success' => true
        ]);
    }
    //add admins  service
    public function add_admin_service(Request $request)
    {
        // Vérifier si l'adresse email est déjà utilisée
        $existingUser = User::where('email', $request->input('email'))->first();

        if ($existingUser) {
            return response()->json([
                'status' => 400,
                'message' => 'Cette adresse email est déjà utilisée.',
                'success' => false
            ]);
        }
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
        $userv = ['email' => $request->email, 'nom' => $request->nom, 'prénom' => $request->prénom, 'password' => $request->password,  'role' => $request->role];
        Mail::to($users->email)->send(new TestEmail($userv));


        return response()->json([
            'status' => 200,
            'message' => 'users added succesuffly',
            'success' => true

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
        $users->num_chambre = $request->input('num_chambre');
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
    public function validerC(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->statut === 'validé') {
            return response()->json([
                'status' => 400,
                'message' => 'L\'utilisateur est déjà validé.',
            ]);
        }

        $user->statut = 'validé';
        $user->update();

        return response()->json([
            'status' => 200,
            'message' => 'Utilisateur validé avec succès.',
        ]);
    }
    public function valideruser(Request $request, $id)
    {
        $user = User::find($id);
        $user->statut = 'validé';
        $user->update();

        return response()->json([
            'status' => 200,
            'message' => 'Utilisateur validé avec succès.',
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
    ///// désactiver un utilisateur
    public function disableUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ]);
        }

        $user->statut = 'désactivé';
        $user->save();

        // Si l'utilisateur désactivé est connecté, le déconnecter immédiatement
        if (Auth::check() && Auth::user()->id === $user->id) {
            Auth::logout();
        }

        return response()->json([
            'status' => 200,
            'message' => 'User disabled successfully',
        ]);
    }

    //recherche par   nom 
    public function searchByName($hotelId, $nom)
    {
        $users = User::where('nom', 'like', '%' . $nom . '%')->where('id_hotel', $hotelId)->get();
        return response()->json($users);
    }
    //rechercher que les clients
    public function searchClientByName($hotelId, $nom)
    {
        $users = User::where('nom', 'like', '%' . $nom . '%')
            ->where('role', 'client')
            ->where('id_hotel', $hotelId)
            ->get();
        return response()->json($users);
    }
    //rechercher que les admins services
    public function searchAdminServiceByName($hotelId, $nom)
    {
        $users = User::where('nom', 'like', '%' . $nom . '%')
            ->where('role', 'admin_service')
            ->where('id_hotel', $hotelId)
            ->get();
        return response()->json($users);
    }
    /// rechercher les admins hotels
    public function searchAdminsByName($nom)
    {
        $admins = User::where('nom', 'like', '%' . $nom . '%')

            ->where('role', 'admin-hotel')
            ->get();

        return response()->json($admins);
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
            ->get()->groupBy(function ($item) {
                return $item->nom_service;
            });

        // renvoyer l'historique en tant que réponse JSON
        return response()->json(['historique' => $historique]);
    }

    public function getHistoriqueByServiceId($id_service)
    {
        // récupérer l'historique associé à l'ID du service
        $historique = DB::table('historique')
            ->join('users', 'historique.id_user', '=', 'users.id')
            ->join('services', 'historique.id_service', '=', 'services.id_service')
            ->where('services.id_service', $id_service)
            ->select('historique.*', 'users.nom as nom_client', 'services.nom as nom_service')
            ->get()->groupBy(function ($item) {
                return $item->nom_service;
            });

        // renvoyer l'historique en tant que réponse JSON
        return response()->json(['historique' => $historique]);
    }
    public function getHistoriqueByClientId($id_client)
    {
        // récupérer l'historique associé à l'ID du client
        $historique = DB::table('historique')
            ->join('users', 'historique.id_user', '=', 'users.id')
            ->join('services', 'historique.id_service', '=', 'services.id_service')
            ->where('users.id', $id_client)
            ->select('historique.*', 'services.nom as nom_service')
            ->get()->groupBy(function ($item) {
                return $item->nom_service;
            });

        // renvoyer l'historique en tant que réponse JSON
        return response()->json(['historique' => $historique]);
    }
    public function getHistoriqueByDate(Request $request, $id_client)
    {
        $date = $request->input('date');

        // récupérer l'historique associé à l'ID du client et à la date spécifiée
        $historique = DB::table('historique')
            ->join('users', 'historique.id_user', '=', 'users.id')
            ->join('services', 'historique.id_service', '=', 'services.id_service')
            ->where('users.id', $id_client)
            ->whereDate('historique.date', '=', $date)
            ->select('historique.*', 'services.nom as nom_service')
            ->get()->groupBy(function ($item) {
                return $item->nom_service;
            });

        // renvoyer l'historique en tant que réponse JSON
        return response()->json(['historique' => $historique]);
    }
    public function stats($id)
    {
        $clientsByMonth = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->where('id_hotel', $id)
            ->where('role', 'client')
            ->groupBy('month')
            ->get();
        // Compter le nombre de clients pour cet hôtel
        $clientsCount = DB::table('users')
            ->where('id_hotel', $id)
            ->where('role', 'client')
            ->count();

        // Compter le nombre d'administrateurs de service pour cet hôtel
        $serviceAdminsCount = DB::table('users')
            ->where('id_hotel', $id)
            ->where('role', 'admin_service')
            ->count();

        // Compter le nombre de services pour cet hôtel
        $servicesCount = DB::table('services')
            ->where('id_hotel', $id)

            ->count();

        // Retourner les statistiques sous forme de tableau JSON
        return response()->json([
            'clients' => $clientsByMonth,
            'clients_count' => $clientsCount,
            'service_admins_count' => $serviceAdminsCount,
            'services_count' => $servicesCount,
        ]);
    }
    public function last3Clients($id_hotel)
    {
        $clients = User::where('role', 'client')
            ->where('id_hotel', $id_hotel)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return response()->json(['clients' => $clients]);
    }
    public function changePassword(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|string|min:6',
        ]);

        // Récupérer l'utilisateur correspondant à l'email
        $user = User::where('email', $request->email)->first();

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Mot de passe mis à jour avec succès'], 200);
    }
}
