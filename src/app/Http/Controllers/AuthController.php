<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function getUser(Request $request){

        $token = $request->token;
        $user = User::where('api_token', $token)->first();
        return response()->json($user, 200);
    }
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // トークンの生成と返却
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->api_token = $token;
        $user->save();

        return response()->json(['user' => $user, 'token' => $token], 201);
    }
    // ユーザーの認証
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            return response()->json(Auth::user());
        }
        return response()->json([], 401);

        return response()->json(['error' => 'Unauthorized'], 401);
    }


    // ユーザーのログアウト
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            Auth::logout();
            return response()->json(['message' => 'Successfully logged out']);
        } else {
            return response()->json(['message' => 'Already logged out']);
        }
        
    }

}

