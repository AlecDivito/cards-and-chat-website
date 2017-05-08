<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {

    }

    public function show()
    {

    }

    public function store(Request $request)
    {
        // middleware (find the user)

        // validataion
        $this->validate($request, [
            'username' => 'required|unique.player,username',
        ]);

        // create the Player
        $player = \App\User::find(1)
            ->player()
            ->create($request->only(['username']));

        // return, and include the user
        return $player->load('player');
    }
}
