<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(($request->user()->only('name', 'email')));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','unique:users,email,'.$request->user->id],
        ]);

        $request->user()->update($validatedData);

        return response()->noContent();
    }
}
