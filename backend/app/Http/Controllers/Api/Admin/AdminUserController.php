<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest()->paginate(15);
        return response()->json($users);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:customer,seller,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rôle mis à jour',
            'user' => $user,
        ]);
    }
}
