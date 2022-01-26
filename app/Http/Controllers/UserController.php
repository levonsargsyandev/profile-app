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
            'password' => ['required', 'confirmed']
        ]);

        $result = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($result){
            $this->login($request);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email', 'password'))){
            return response()->json(['success' => true]);
        }

        throw ValidationException::withMessages([
            'error' => ['The given data was invalid.']
        ]);
    }
    public function logout()
    {
        Auth::logout();
    }
}
