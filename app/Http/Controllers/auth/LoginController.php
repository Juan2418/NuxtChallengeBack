<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $login = request()->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($login)) {
            return response('Invalid Credentials', 404);
        }

        $authenticatedUserID = Auth::user()->id;
        $userInfo = User::with('articles')->find($authenticatedUserID);

        return response(['user' => $userInfo]);
    }
}
