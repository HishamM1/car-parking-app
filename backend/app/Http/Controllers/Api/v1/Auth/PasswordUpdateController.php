<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PasswordUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required' , 'confirmed']
        ]);

        $request->user()->update([
            'password' => $request->input('password')
        ]);

        return response()->json([
            'message' => 'Password updated successfully.',
        ], Response::HTTP_ACCEPTED);

    }
}
