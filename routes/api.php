<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Games Routes...
Route::get ('games', 'GameController@index');  // get all available games
Route::post('games', 'GameController@store'); // store a new game

// Deck Routes...
Route::match(['get', 'post'], 'games/deck/fresh'          , 'DeckController@freshDeck');
Route::match(['get', 'post'], 'games/deck/shuffled'       , 'DeckController@freshShuffledDeck');
Route::match(['get', 'post'], 'games/deck/reshuffle'      , 'DeckController@reShuffle');
Route::match(['get', 'post'], 'games/deck/draw'           , 'DeckController@draw');
Route::match(['get', 'post'], 'games/deck/discard'        , 'DeckController@discard');
Route::match(['get', 'post'], 'games/deck/discarddraw', 'DeckController@drawFromDiscard');

// ChatRoom Routes...
Route::get('chatrooms', 'ChatRoomController@index');
Route::get('chatrooms/{room}', 'ChatRoomController@show');
Route::post('chatrooms', 'ChatRoomController@store');
Route::post('fire/{room}', 'ChatRoomController@fire');


/*
 * Test Routes
 */
Route::get('test', function () {
    return (\Illuminate\Support\Facades\Auth::check()) ? 'true': 'false';
});

// Online websocket Chat routes...
Route::post('fire', function (Request $request) {
    event(new \App\Events\OnlineChat(
                                     \Illuminate\Support\Facades\Request::input('message'),
            \Illuminate\Support\Facades\Auth::user()
        )
    );
    return 'success';
});