<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $vaildated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','unique:users,email'],
            'password' => ['required','confirmed'],
        ]);

        $user = User::create($vaildated);

        event(new Registered($user));

        $device = substr($request->userAgent() ?? '' , 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ], Response::HTTP_CREATED);
    }
}
