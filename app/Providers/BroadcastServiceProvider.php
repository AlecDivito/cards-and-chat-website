<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes(['middleware' => ['web', 'auth']]);

        Broadcast::channel('event-example', function (User $user) {
            return true;
        });

        Broadcast::channel('event-example-2', function (User $user) {
            return $user;
        });


        Broadcast::channel('private-chat-room.{chatroom_id}', function (User $user, $chatroom_id) {
            if (\App\ChatRoom::where('id', $chatroom_id)->exists())
            {
                return $user;
            }
        });

        Broadcast::channel('presence-chat-room', function (User $user) {
            return $user;
        });



    }
}
