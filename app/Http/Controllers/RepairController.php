<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RepairService;

class RepairController extends Controller
{
    protected $repairService;

    public function __construct(RepairService $repairService)
    {
        $this->repairService = $repairService;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'nullable|integer|min:1',
        ]);

        $vehicleId = $validated['vehicle_id'] ?? null;
        $repairs = $this->repairService->listRepairs($vehicleId);
        return response()->json($repairs);
    }

    public function show($id)
    {
        $validated = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $repair = $this->repairService->getRepairById($validated['id']);
        
        if (!$repair) {
            return response()->json(['error' => 'Repair not found'], 404);
        }

        return response()->json($repair);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date|after_or_equal:started_at',
            'total_cost' => 'required|numeric|min:0',
            'is_paid' => 'required|boolean',
        ]);

        $repair = $this->repairService->createRepair($validated);
        return response()->json($repair, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedId = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $validated = $request->validate([
            'vehicle_id' => 'sometimes|required|integer|exists:vehicles,id',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|string|max:255',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date|after_or_equal:started_at',
            'total_cost' => 'sometimes|required|numeric|min:0',
            'is_paid' => 'sometimes|required|boolean',
        ]);

        $repair = $this->repairService->updateRepair($validatedId['id'], $validated);
        if (!$repair) {
            return response()->json(['error' => 'Repair not found'], 404);
        }
        return response()->json($repair);
    }

    public function destroy($id)
    {
        $validated = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $deleted = $this->repairService->deleteRepair($validated['id']);
        return response()->json(null, $deleted ? 204 : 404);
    }

    public function updateRepairStatus(Request $request, $id)
    {
        $validatedId = validator(['id' => $id], [
            'id' => 'required|integer|min:1',
        ])->validate();

        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $repair = $this->repairService->getRepairById($validatedId['id']);
        if (!$repair) {
            return response()->json(['error' => 'Repair not found'], 404);
        }

        $repair->status = $validated['status'];
        $repair->save();

        return response()->json($repair);
    }
}
