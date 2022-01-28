<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * Register a user
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'firstName' => ['required', 'string'],
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

        return response()->json(['success' => false]);
    }


    /**
     * Login a user
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => true, 'user' => Auth::user()]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Logout a user
     *
     * @return void
     */

    public function logout()
    {
        Auth::logout();
    }


    /**
     * Update a user
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function updateUser(Request $request): JsonResponse
    {
        if ($request->email !== $request->user()->email) {
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

        return response()->json(['success' => false]);
    }
}
