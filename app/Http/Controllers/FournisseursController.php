<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseursController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fournisseurs = Fournisseur::where('user_id', auth()->id())->get();
        return view('fournisseurs.fournisseurs', compact('fournisseurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        Fournisseur::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Fournisseur added successfully!', 'status' => 'success']);
        }

        return redirect()->route('fournisseurs')->with('success', 'Fournisseur added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $fournisseur = Fournisseur::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $fournisseur->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Fournisseur updated successfully!', 'status' => 'success']);
        }

        return redirect()->route('fournisseurs')->with('success', 'Fournisseur updated successfully!');
    }

    public function destroy($id)
    {
        $fournisseur = Fournisseur::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $fournisseur->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Fournisseur deleted successfully!', 'status' => 'success']);
        }

        return redirect()->route('fournisseurs')->with('success', 'Fournisseur deleted successfully!');
    }

    public function show($id)
    {
        $fournisseur = Fournisseur::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return response()->json($fournisseur);
    }
}
