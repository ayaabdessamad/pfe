<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;

use App\Models\User;
use App\Notifications\CommandePassee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchatsController extends Controller
{
    // fonction pour vérifier si le client a suffisamment de solde pour acheter un plan de la salle de sport
    public function acheterPlanSalleSport(Request $request)
    {
        $id_client = $request->input('id_client');
        $id_plan = $request->input('id_plan');

        // récupérer les informations du client depuis la base de données
        $client = DB::table('users')->where('id', $id_client)->first();

        // récupérer les informations du plan depuis la base de données
        $plan = DB::table('plans')->where('id', $id_plan)->first();

        // vérifier si le client a suffisamment de solde pour acheter le plan
        if ($client->solde >= $plan->prix) {

            // déduire le prix du plan du solde du client et mettre à jour le solde dans la base de données
            $nouveau_solde = $client->solde - $plan->prix;
            DB::table('users')->where('id', $id_client)->update(['solde' => $nouveau_solde]);

            // enregistrer les informations de l'achat dans la table d'historique
            $historique = [
                'id_user' => $id_client,
                'id_service' => $plan->id_service,
                'montant' => $plan->prix,
                'id_hotel' => $request->input('id_hotel'),
                'date' => now()
            ];
            DB::table('historique')->insert($historique);

            // enregistrer les informations de l'achat dans la base de données
            $achat = [
                'id_client' => $id_client,
                'id_plan' => $id_plan,
                'montant_paye' => $plan->prix
            ];
            DB::table('achats_plans')->insert($achat);
            // envoyer une notification à l'admin
            $id_user = $id_client;
            $service_id = $plan->id_service;
            $admin = User::where('role', 'admin_service')->where('id_service', $plan->id_service)->first();
            $id_admin = $admin->id;
            //event(new MyEvent($plan->prix, $id_user, $id_admin, $service_id));
            //creer un evenement 
            //event(new MyEvent('Nouvelle commande passée'));

            $admin->notify(new CommandePassee($plan->prix, $id_user, $id_admin, $service_id));


            // renvoyer un message de succès à l'utilisateur
            return response()->json(['status' => 200, 'success' => true, 'message' => 'Félicitations le Plan est acheté avec succès.']);
        } else {
            // renvoyer un message d'erreur à l'utilisateur
            return response()->json(['success' => false, 'message' => 'Désolé votre Solde est insuffisant pour acheter ce plan recharger votre compte et résayer.']);
        }
    }
}
