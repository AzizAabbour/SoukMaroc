<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->orderBy('is_default', 'desc')->get();
        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'is_default' => 'boolean',
        ]);

        $userId = $request->user()->id;

        if ($request->is_default) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
        }

        $address = Address::create([
            'user_id' => $userId,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'city' => $request->city,
            'region' => $request->region,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'is_default' => $request->is_default ?? ($request->user()->addresses()->count() === 0),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Adresse ajoutée avec succès',
            'address' => $address,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $address = $request->user()->addresses()->findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            Address::where('user_id', $request->user()->id)->update(['is_default' => false]);
        }

        $address->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Adresse mise à jour',
            'address' => $address,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $address = $request->user()->addresses()->findOrFail($id);
        $address->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Adresse supprimée',
        ]);
    }

    public function setDefault(Request $request, $id)
    {
        Address::where('user_id', $request->user()->id)->update(['is_default' => false]);

        $address = $request->user()->addresses()->findOrFail($id);
        $address->update(['is_default' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Adresse par défaut mise à jour',
            'address' => $address,
        ]);
    }
}
