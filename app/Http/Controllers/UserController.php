<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $auth = false;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            $auth = true; // Successful log in
        }

        return response()->json([
            'auth' => $auth,
            'intended' => URL::previous()
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:32',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
        ]);

        $this->guard()->login($user);

        return $this->registered($request, $user);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
