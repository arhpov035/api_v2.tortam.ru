<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthSanctumController extends Controller
{
    public function registration(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
//        return response()->json($user, 200);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
//        $user->password = Hash::make($request->input('password'));
        $user->password = $request->input('password');

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false
            ], 200);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json([
            'success' => true,
            'token' => $token
        ], 200)->withCookie($cookie);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }

    public function user()
    {
        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'user' => Auth::user()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 200);
        }
    }
}
