<?php

namespace App\Http\Controllers;

use App\Models\fournisseur;
use Illuminate\Http\Request;

class FournisseursController extends Controller
{

    public function index()
    {
        $fournisseurs = fournisseur::all();
        return response()->json($fournisseurs);
    }

    public function fournisseursPage()
    {
        $fournisseurs = Fournisseur::all();
        return view('fournisseurs.fournisseurs', compact('fournisseurs'));
    }


    public function show($id)
    {
        $fournisseur = fournisseur::findOrFail($id);
        return response()->json($fournisseur);
    }





    public function store2(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',
            ]);

            $fournisseur = fournisseur::create($validated);
            return response()->json($fournisseur, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Failed: ', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        }


    }


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
    ]);

    $fournisseur = fournisseur::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
        'user_id' => auth()->id(),
    ]);

    return response()->json($fournisseur, 201);
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $fournisseur = fournisseur::findOrFail($id);
        $fournisseur->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json($fournisseur);
    }

    public function destroy($id)
    {
        $fournisseur = fournisseur::findOrFail($id);
        $fournisseur->delete();

        return response()->json(['message' => 'fournisseur deleted successfully']);
    }
}
