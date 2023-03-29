<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function ajouterCommande(Request $request)
    {
        $id_client = $request->input('id_client');
        $id_plat = $request->input('id_plat');
        $quantite = $request->input('quantite');

        // Récupérer le solde du client
        $solde = DB::table('users')->where('id', $id_client)->value('solde');

        // Calculer le montant total de la commande
        $prix_unitaire = DB::table('plats')->where('id', $id_plat)->value('prix');
        $prix_total = $quantite * $prix_unitaire;

        // Vérifier si le solde est suffisant pour couvrir le coût total de la commande
        if ($solde < $prix_total) {
            return response()->json(['message' => 'solde insuffisant.']);
        }

        // Autoriser l'ajout de la commande
        DB::table('commande')->insert([

            'id_plat' => $id_plat,
            'id_client' => $id_client,
            'quantite' => $quantite,

            'prix' => $prix_total,
        ]);

        // Mettre à jour le solde du client
        DB::table('users')->where('id', $id_client)->decrement('solde', intval($prix_total));

        return response()->json(['message' => 'Commande ajoutée avec succès.']);
    }
}
