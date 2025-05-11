<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }
    public function clientsPage()
    {
        $clients = Client::all();
        return view('clients.clients', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
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

            $client = Client::create($validated);
            return response()->json($client, 201);
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

        $client = Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Client added successfully!', 'client' => $client], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $client = Client::findOrFail($id);
        $client->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json($client);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
}
