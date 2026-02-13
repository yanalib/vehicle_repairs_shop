<?php
namespace App\Services;

use App\Models\Repair;

class RepairService
{
	public function createRepair(array $data): Repair
	{
		return Repair::create($data);
	}

	public function getRepairById(int $id): ?Repair
	{
		return Repair::find($id);
	}

	public function updateRepair(int $id, array $data): ?Repair
	{
		$repair = Repair::find($id);
		if ($repair) {
			$repair->update($data);
		}
		return $repair;
	}
    
	public function deleteRepair(int $id): bool
	{
		$repair = Repair::find($id);
		if ($repair) {
			return $repair->delete();
		}
		return false;
	}

	/**
	 * List all repairs, optionally filtered by vehicle.
	 */
	public function listRepairs(?int $vehicleId = null)
	{
		if ($vehicleId) {
			return Repair::where('vehicle_id', $vehicleId)->get();
		}
		return Repair::all();
	}
}
