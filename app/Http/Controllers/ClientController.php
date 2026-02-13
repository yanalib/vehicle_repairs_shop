<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientService;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->getAllClients() ?: [];
        return response()->json($clients);
    }

    public function show(Request $request, $id)
    {
        $validated = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $client = $this->clientService->getClientById($validated['id']);
        
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
        return response()->json($client);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        $client = $this->clientService->createClient($validated);
        return response()->json($client, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedId = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:clients,email,' . $validatedId['id'],
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $client = $this->clientService->updateClient($validatedId['id'], $validated);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
        return response()->json($client);
    }

    public function destroy($id)
    {
        $validated = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $deleted = $this->clientService->deleteClient($validated['id']);
        return response()->json(null, $deleted ? 204 : 404);
    }
}
