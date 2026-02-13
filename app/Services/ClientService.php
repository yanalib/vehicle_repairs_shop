<?php
namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function getAllClients()
    {
        return Client::all();
    }

	public function createClient(array $data): Client
	{
		return Client::create($data);
	}

	public function getClientById(int $id): ?Client
	{
		return Client::find($id);
	}

	public function updateClient(int $id, array $data): ?Client
	{
		$client = Client::find($id);
		if ($client) {
			$client->update($data);
		}
		return $client;
	}

	public function deleteClient(int $id): bool
	{
		$client = Client::find($id);
		if ($client) {
			return $client->delete();
		}
		return false;
	}
}