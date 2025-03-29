<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::where('user_id', auth()->id())->get();
        return view('clients', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Client added successfully!', 'status' => 'success']);
        }

        return redirect()->route('clients')->with('success', 'Client added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $client = Client::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $client->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Client updated successfully!', 'status' => 'success']);
        }

        return redirect()->route('clients')->with('success', 'Client updated successfully!');
    }

    public function destroy($id)
    {
        $client = Client::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $client->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Client deleted successfully!', 'status' => 'success']);
        }

        return redirect()->route('clients')->with('success', 'Client deleted successfully!');
    }

    public function show($id)
    {
        $client = Client::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return response()->json($client);
    }
}
