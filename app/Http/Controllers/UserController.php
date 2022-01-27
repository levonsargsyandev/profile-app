<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Register a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $response = User::create([
            'first_name' => $request->firstName ?? null,
            'last_name' => $request->lastName ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($response) {
            return response()->json(['success' => true]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => true, 'user' => Auth::user()]);
        }

        throw ValidationException::withMessages([
            'error' => ['The given data was invalid.']
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function updateUser(Request $request)
    {
        if($request->email !== $request->user()->email){
            $request->validate([
                'email' => ['required', 'email', 'unique:users']
            ]);
        }

        $user = User::findOrFail($request->user()->id);

        $response = $user->update([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email
        ]);

        if ($response) {
            return response()->json(['success' => true, 'user' => $user]);
        }
    }
}
