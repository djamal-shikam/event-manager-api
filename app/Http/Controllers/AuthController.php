<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Accès non autorisée'
            ],401);
        }
    
        $user = $request->user();
        $tokenResult = $user->createToken('Token d\'accès personnel');
        $token = $tokenResult->plainTextToken;
    
        return response()->json([
            'accessToken' =>$token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
       $request->user()->tokens()->delete();

       return response()->json(['message' => 'Déconnexion réussie']);
    }
}
