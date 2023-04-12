<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $token = Auth::attempt(Arr::only($request->input(), ['username', 'password']));
        throw_if($token === false, new AuthenticationException());

        return new DataResource([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return new DataResource();
    }

    public function me()
    {
        $user = Auth::user();

        return new DataResource([
            'id' => $user->id,
            'nickname' => $user->nickname,
            'avatar' => $user->avatar,
        ]);
    }
}
