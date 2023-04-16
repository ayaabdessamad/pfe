<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Plat;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanierController extends Controller

{
    public function ajouterAuPanier(Request $request)
    {
        $user = Auth::user();
        $id_client = $request->input('id_client');
        $plat_id = $request->input('id_plat');
        $quantite = $request->input('quantite');

        $plat = Plat::findOrFail($plat_id);
        $prix_unitaire = $plat->prix;
        // Récupérer le solde du client
        $solde = DB::table('users')->where('id', $id_client)->value('solde');
        // Calculer le montant total de la commande
        $prix_unitaire = DB::table('plats')->where('id', $plat_id)->value('prix');
        $prix_total = $quantite * $prix_unitaire;
        // Vérifier si le solde est suffisant pour couvrir le coût total de la commande
        if ($solde < $prix_total) {
            return response()->json(['success' => false, 'message' => 'Désolé votre Solde est insuffisant recharger votre compte et résayer']);
        }
        // Autoriser l'ajout au panier
        DB::table('panier')->insert([

            'id_plat' => $plat_id,
            'id_client' => $id_client,
            'quantite' => $quantite,

            'prix' => $prix_total,
        ]); // Mettre à jour le solde du client
        // DB::table('users')->where('id', $id_client)->decrement('solde', intval($prix_total));

        return response()->json(['status' => 200, 'success' => true, 'message' => ' Ajoutée au panier avec succès.']);
    }
    public function getPanierByClientId($id_client)
    {
        $panier = DB::table('panier')
            ->join('plats', 'panier.id_plat', '=', 'plats.id')
            ->select('plats.nom', 'plats.image', 'panier.id', 'panier.quantite', 'panier.prix')
            ->where('panier.id_client', $id_client)
            ->get();

        return response()->json(['panier' => $panier]);
    }
    public function destroy($id)
    {
        $panier = Panier::findOrFail($id);
        $panier->delete();

        return response()->json([
            'message' => 'Plat supprimé du panier avec succès!'
        ]);
    }
}
