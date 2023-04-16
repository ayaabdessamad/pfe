<?php

use App\Http\Controllers\AchatsController;
use App\Http\Controllers\AdminHotelController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OffresController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PlatsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{localisation}', [HotelController::class, 'gethotelbylocalisation']);
Route::get('/hotelsMonastir', [HotelController::class, 'gethotelsM']);
Route::get('/hotelsSousse', [HotelController::class, 'gethotelsS']);
Route::get('/hotelsHammamet', [HotelController::class, 'gethotelsH']);
Route::get('/hotelsDjerba', [HotelController::class, 'gethotelsD']);
Route::get('/hotelsTunis', [HotelController::class, 'gethotelsT']);
Route::get('/hotelsMahdia', [HotelController::class, 'gethotelsMA']);
Route::get('/hotelsTozeur', [HotelController::class, 'gethotelsTO']);
Route::get('/hotelsGammarth', [HotelController::class, 'gethotelsG']);
Route::get('/search/{nom}', [HotelController::class, 'searchByName']);
//Route::get('/search', [HotelController::class, 'searchByFilter']);
Route::get('/pays', [PaysController::class, 'index']);


Route::get('/users', [PersonneController::class, 'index']);



Route::put('/désactiver-user/{id}', [PersonneController::class, 'desactiver']);
Route::get('/clients/{hotelId}', [PersonneController::class, 'getclients']);



//routes of table service
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/edit-service/{id}', [ServiceController::class, 'edit']);
Route::get('/services/{id_hotel}', [ServiceController::class, 'getservicesbyidhotel']);
Route::get('/searchS/{nom}', [ServiceController::class, 'searchByName']);

Route::get('/menu/{id_service}', [MenuController::class, 'getmenubyidservice']);
Route::get('/plats/{id}', [PlatsController::class, 'get_plat_by_idmenu']);



Route::get('/plans/{id_service}', [PlansController::class, 'getplansbyidservice']);


Route::get('/searchU/{nom}', [PersonneController::class, 'searchByName']);
Route::get('/searchC/{hotelId}/{nom}', [PersonneController::class, 'searchClientByName']);
Route::post('/ajouterCommande', [CommandController::class, 'ajouterCommande']);
Route::post('/ajouterachat', [AchatsController::class, 'acheterPlanSalleSport']);
Route::post('/ajouteraupanier', [PanierController::class, 'ajouterAuPanier']);
Route::get('/panier/{id_client}', [PanierController::class, 'getPanierByClientId']);
Route::delete('/panier/{id}', [PanierController::class, 'destroy']);






//////les historiques
Route::get('/historique/{id_hotel}', [PersonneController::class, 'getHistoriqueByHotelId']);
Route::get('/historiqueS/{id_service}', [PersonneController::class, 'getHistoriqueByServiceId']);
Route::get('/historiqueC/{id_client}', [PersonneController::class, 'getHistoriqueByClientId']);

// les fonctions autorisés pour l'admin service
Route::middleware(['jwt.verify', 'CheckRole:admin_service'])->group(function () {
    Route::delete('/delete-plat/{id}', [PlatsController::class, 'delete_plat']);
    Route::delete('/delete-plan/{id}', [PlansController::class, 'deletePlan']);
    Route::put('/update-plat/{id}', [PlatsController::class, 'update_plat']);
    Route::get('/plat/{id}', [PlatsController::class, 'get_plat_details']);
    Route::post('/add-plat', [PlatsController::class, 'add_plat']);
    Route::put('/update-plan/{id}', [PlansController::class, 'update_plan']);
    Route::get('/plan/{id}', [PlansController::class, 'get_plan_details']);
    Route::post('/add-plan', [PlansController::class, 'add_plan']);
});


// les fonctions autorisés pour l'admin et le client
Route::middleware(['jwt.verify', 'CheckRole:client,admin'])->group(function () {
    Route::get('/edit-hotel/{id}', [HotelController::class, 'edit']);
});

// les fonctions autorisés pour l'admin et l'admin hotel 
Route::middleware(['jwt.verify', 'CheckRole:admin-hotel,admin'])->group(function () {
    Route::delete('/delete-user/{id}', [PersonneController::class, 'delete']);
    Route::get('/edit-user/{id}', [PersonneController::class, 'edit']);
    Route::put('/update-user/{id}', [PersonneController::class, 'update']);
    Route::put('/update-admin/{id}', [PersonneController::class, 'update_admin']);
});

// les fonctions autorisés pour l'admin
Route::middleware(['jwt.verify', 'CheckRole:admin'])->group(function () {
    Route::delete('/delete-hotel/{id}',  [HotelController::class, 'delete']);
    Route::post('/add-hotel', [HotelController::class, 'store']);

    Route::put('/update-hotel/{id}', [HotelController::class, 'update']);
    Route::get('/admins', [PersonneController::class, 'getadmins']);
    Route::post('/add-admin', [PersonneController::class, 'store']);


    Route::get('/debug', function () {
        $user = auth()->user();
        $role = request()->route()->getAction()['CheckRole'];
        dd($user, $role);
    });
});
// les fonctions autorisés pour unclient
Route::middleware(['jwt.verify', 'CheckRole:client'])->group(function () {
});

// les fonctions autorisés pour l'admin-hotel
Route::middleware(['jwt.verify', 'CheckRole:admin-hotel'])->group(function () {
    Route::post('/add-service', [ServiceController::class, 'store']);
    Route::get('/adminsS/{hotelId}', [PersonneController::class, 'getadmins_Service']);
    Route::put('/update-service/{id}', [ServiceController::class, 'update']);
    Route::delete('/delete-service/{id}', [ServiceController::class, 'delete']);
    Route::post('/add_admin_service', [PersonneController::class, 'add_admin_service']);
});
Route::put('/valider-user/{id}', [PersonneController::class, 'validerC']);




//authentification
Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api', 'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers',
], function ($router) {


    Route::post('/login', [AdminHotelController::class, 'login']);
    Route::post('/create', [AdminHotelController::class, 'register']);
    Route::get('/profile', [AdminHotelController::class, 'profile']);
    Route::post('/logout', [AdminHotelController::class, 'logout']);
    // Route::post('/loginUser', [PersonneController::class, 'loginUser']);
    Route::get('/users', [PersonneController::class, 'index']);
    // Route::get('/profile', [PersonneController::class, 'profile']);
    // Route::post('/logout', [PersonneController::class, 'logout']);
});
