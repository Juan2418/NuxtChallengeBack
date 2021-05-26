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

        return response(['user' => $userInfo]);
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
