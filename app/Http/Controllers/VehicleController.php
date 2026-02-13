<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VehicleService;

class VehicleController extends Controller
{
    protected $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|integer|min:1',
        ]);

        $clientId = $validated['client_id'] ?? null;
        $vehicles = $this->vehicleService->listVehicles($clientId);
        return response()->json($vehicles);
    }

    public function show($id)
    {
        $validated = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $vehicle = $this->vehicleService->getVehicleById($validated['id']);
        
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        return response()->json($vehicle);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reg_no' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1886',
            'vin' => 'required|string|max:255',
            'client_id' => 'required|integer|exists:clients,id',
        ]);

        $vehicle = $this->vehicleService->createVehicle($validated);
        return response()->json($vehicle, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedId = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $validated = $request->validate([
            'reg_no' => 'sometimes|required|string|max:255',
            'make' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1886',
            'vin' => 'sometimes|required|string|max:255',
            'client_id' => 'sometimes|required|integer|exists:clients,id',
        ]);

        $vehicle = $this->vehicleService->updateVehicle($validatedId['id'], $validated);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        return response()->json($vehicle);
    }

    public function destroy($id)
    {
        $validated = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();
        
        $deleted = $this->vehicleService->deleteVehicle($validated['id']);
        return response()->json(null, $deleted ? 204 : 404);
    }
}
