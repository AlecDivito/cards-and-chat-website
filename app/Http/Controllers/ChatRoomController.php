<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use App\Events\ChatRoomBroadcaster;
use App\Repositories\IPGeolocationAPIRepository;
use App\Repositories\WeatherAPIRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\Rule;

class ChatRoomController extends Controller
{

    public function request(Request $request, WeatherAPIRepository $APIRepository)
    {
        /*$this->validate($request, [
            'ip' => 'required|ip',
            'q'  => 'string|max:60'
        ]);*/

        // for right now for testing the ip
        $request['ip'] = '99.233.77.223';

        return $APIRepository->getWeather([
            'ip' => $request['ip'],
            // 'q' => 'mississauga' // for testing we'll keep q = mississauga
            // but when IPGeoloca... works we'll see if we can just get the location with the ip
        ]);
    }


    public function index() {
        return ChatRoom::all();
    }

    public function show(ChatRoom $room) {

    }

    public function store(Request $request) {
        $this->validate($request, [
            'name'      => 'required|min:4|max:32|string',
            'status'    => ['required',Rule::in(['public','private'])],
            'password'  => 'required_if:status,private|nullable|max:32',
        ]);

        ChatRoom::create([
            'name'     => $request->input('name'),
            'status'   => $request->input('status'),
            'password' => $request->input('password'),
            'user_id'  => Auth::id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "{$request->input('name')} was created successfully"
        ]);
    }

    public function fire($chatroom_id, Request $request) {
        Event::fire(new ChatRoomBroadcaster(Auth::user(),$request->input('message'), $chatroom_id))/*->toOthers()*/;
        return 'success';
    }

}
