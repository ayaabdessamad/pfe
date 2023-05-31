<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('private-channel', function ($user) {
    // Votre logique d'authentification pour les canaux privés
    return true; // ou false si l'utilisateur n'est pas authentifié
});*/

/*Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('admin-service-channel', function ($user) {
    // return true si l'utilisateur est un admin service
    return $user->role === 'admin_service';
});
/*Broadcast::channel('my-channel', function ($user) {
    return $user->role === 'admin_service';
});*/
