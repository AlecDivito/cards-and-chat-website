<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('weather', 'ChatRoomController@request')->middleware('requestIP');


Route::get('/', function () {
    return view('welcome');
});


// Authentication routes...
Route::post('login', 'UserController@login');
Route::post('logout', 'UserController@logout')->name('logout');

// Register routes...
Route::post('register', 'UserController@register');


Route::get('index', function () {
    return 'socket';
});
Route::get('writemessage', function () {
    return 'writemessage';
});
Route::post('sendmessage', function () {
    $redis = Redis::connection();
    $redis->publish('message', \Illuminate\Support\Facades\Request::input('message'));
    return 'messageWrote';
});

// Testing Routes...
Route::post('/fire', function () {
    // this fires the event
    // Event::fire(new \App\Events\EventName(Auth::User()));

    event(new \App\Events\EventName(\Illuminate\Support\Facades\Request::input('message')));

    return "event fired";
});
