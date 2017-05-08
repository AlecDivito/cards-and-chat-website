<?php

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

\Illuminate\Support\FacadesLog::Debug('set up broadcast routes');


Broadcast::channel('User.{id}', function ($user, $id) {
    return true;
});

Broadcast::channel('chat-channel', function ($user) {
    Log::Debug('hello inside chat-channel');

    return $user;
});

Broadcast::channel('chat-room.{chatroom_id}', function (User $user, $chatroom_id) {
    return true; //return $user->check() && \App\ChatRoom::where('id', $chatroom_id)->exists();
});



