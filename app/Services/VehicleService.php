<?php
namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{
	public function createVehicle(array $data): Vehicle
	{
		return Vehicle::create($data);
	}

	public function getVehicleById(int $id): ?Vehicle
	{
		return Vehicle::find($id);
	}

	public function updateVehicle(int $id, array $data): ?Vehicle
	{
		$vehicle = Vehicle::find($id);
		if ($vehicle) {
			$vehicle->update($data);
		}
		return $vehicle;
	}

	public function deleteVehicle(int $id): bool
	{
		$vehicle = Vehicle::find($id);
		if ($vehicle) {
			return $vehicle->delete();
		}
		return false;
	}

	public function listVehicles(?int $clientId = null)
	{
		if ($clientId) {
			return Vehicle::where('client_id', $clientId)->get();
		}
		return Vehicle::all();
	}
}
