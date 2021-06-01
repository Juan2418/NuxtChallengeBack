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
        $login = $this->getValidatedCredentials();

        if ($this->isNotValidUser($login)) {
            return response('Invalid Credentials', 404);
        }

        $userInfo = $this->getLoggedUserInfo();
        $token = Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => $userInfo, 'access_token' => $token]);
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return response(['Logged out successfully'], 200);
    }

    public function user()
    {
        $userInfo = $this->getLoggedUserInfo();

        return response(['user' => $userInfo]);
    }

    public function register()
    {
        $newCredentials = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $newCredentials['password'] = bcrypt($newCredentials['password']);

        User::create($newCredentials);

        return response(['Registered successfully'], 200);
    }

    /**
     * @param array $login
     * @return bool
     */
    private function isNotValidUser(array $login): bool
    {
        return !Auth::attempt($login);
    }

    /**
     * @return array
     */
    private function getValidatedCredentials(): array
    {
        $login = request()->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        return $login;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private function getLoggedUserInfo()
    {
        $authenticatedUserID = Auth::user()->id;
        $userInfo = User::with('articles')->find($authenticatedUserID);
        return $userInfo;
    }
}
