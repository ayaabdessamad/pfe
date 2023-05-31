<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Models\achats_plans;
use App\Models\User;
use App\Notifications\CommandePassee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;

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
                'montant_paye' => $plan->prix,
                'date' => now()->toDateString(), // Récupère la date actuelle
                'time' => $request->input('time')

            ];
            DB::table('achats_plans')->insert($achat);
            // envoyer une notification à l'admin
            $id_user = $id_client;
            $service_id = $plan->id_service;
            $admin = User::where('role', 'admin_service')->where('id_service', $plan->id_service)->first();
            //$id_admin = $admin->id;




            //event(new MyEvent($plan->prix, $id_user, $id_admin, $service_id));
            //creer un evenement 
            //event(new MyEvent($message));
            $data = [
                'message' => 'Nouvelle achat',
                'achat' => $achat,
            ];
            Event::dispatch(new MyEvent($achat));

            //$admin->notify(new CommandePassee($plan->prix, $id_user, $id_admin, $service_id));


            // renvoyer un message de succès à l'utilisateur
            return response()->json(['status' => 200, 'success' => true, 'message' => 'Félicitations le Plan est acheté avec succès.']);
        } else {
            // renvoyer un message d'erreur à l'utilisateur
            return response()->json(['success' => false, 'message' => 'Désolé votre Solde est insuffisant pour acheter ce plan recharger votre compte et résayer.']);
        }
    }
    public function getReservations($id_plan)
    {
        // Récupérer toutes les réservations pour le plan spécifié
        $reservations = achats_plans::select('date', 'time')
            ->where('id_plan', $id_plan)
            ->get();

        // Plage horaire disponible de 10h à 21h
        $heure_debut = '10:00';
        $heure_fin = '21:00';

        // Générer tous les temps possibles dans la plage horaire spécifiée avec un intervalle de 1 heure et 30 minutes
        $temps_possibles = [];
        $heure_actuelle = $heure_debut;
        while ($heure_actuelle <= $heure_fin) {
            $temps_possibles[] = $heure_actuelle;
            $heure_actuelle = date('H:i', strtotime($heure_actuelle) + (90 * 60));  // Intervalles de 1 heure et 30 minutes
        }

        // Filtrer les temps déjà réservés
        $temps_deja_reserves = $reservations->pluck('time')->toArray();

        // Convertir les temps déjà réservés au format heure:minute
        $temps_deja_reserves = array_map(function ($temps) {
            return date('H:i', strtotime($temps));
        }, $temps_deja_reserves);

        $temps_disponibles = array_diff($temps_possibles, $temps_deja_reserves);


        // Grouper les temps disponibles par date
        $dates_temps_disponibles = [];
        $current_date = date('Y-m-d');
        $date_temps = [
            'date' => $current_date,
            'times' => []
        ];

        foreach ($temps_disponibles as $temps) {
            // Vérifier si la date a changé
            if ($current_date != date('Y-m-d', strtotime($temps))) {
                $dates_temps_disponibles[] = $date_temps;
                $current_date = date('Y-m-d', strtotime($temps));
                $date_temps = [
                    'date' => $current_date,
                    'times' => []
                ];
            }

            $date_temps['times'][] = $temps;
        }

        // Ajouter le dernier ensemble de temps disponibles à la liste
        if (!empty($date_temps['times'])) {
            $dates_temps_disponibles[] = $date_temps;
        }

        // Retourner les dates avec les temps disponibles
        $result = [
            'reservations' => $dates_temps_disponibles
        ];

        return response()->json($result);
    }
}
