<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json([
            ['url' =>'/games/blackjack',   'name'=>'Black Jack'],
            ['url' =>'/games/war',         'name'=>'War'],
            ['url' =>'/games/poker',       'name'=>'Poker'],
            ['url' =>'/games/suggestions', 'name'=>'Suggestions'],
            ['url' =>'/games/chat',        'name'=>'Online Chat'],
        ]);
    }

    public function store()
    {

    }
}
