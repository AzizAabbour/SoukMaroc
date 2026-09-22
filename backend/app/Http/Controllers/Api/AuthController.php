<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|in:customer,seller',
            'store_name' => 'required_if:role,seller|nullable|string|max:255|unique:sellers,store_name',
            'city' => 'nullable|string|max:255',
        ]);

        $role = $request->role === 'seller' ? 'seller' : 'customer';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $role,
            'city' => $request->city ?? 'Casablanca',
        ]);

        if ($role === 'seller') {
            Seller::create([
                'user_id' => $user->id,
                'store_name' => $request->store_name ?? $user->name . ' Store',
                'slug' => Str::slug($request->store_name ?? $user->name . ' Store') . '-' . rand(100, 999),
                'description' => 'Boutique marocaine sur SoukMaroc',
                'is_verified' => false,
                'rating' => 5.0,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Compte créé avec succès',
            'user' => $user->load('seller'),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants fournis sont incorrects.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Connexion réussie',
            'user' => $user->load(['seller', 'addresses']),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Déconnexion réussie',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user()->load(['seller', 'addresses']),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'phone', 'city', 'region']));

        return response()->json([
            'status' => 'success',
            'message' => 'Profil mis à jour avec succès',
            'user' => $user->load(['seller', 'addresses']),
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Mot de passe actuel incorrect.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mot de passe modifié avec succès',
        ]);
    }
}
