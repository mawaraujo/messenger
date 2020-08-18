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

// Definimos un callback, para autorizar solo al usuario con el permiso
Broadcast::channel('users.{id}', function($user, $id) {
    return (int) $user->id === (int) $id;
});

// Autorizamos en un presence channel
Broadcast::channel('messenger', function($user) {
    if ($user) {
        $response = $user->toArray();
        return $response;
    }
    
    return false;
});