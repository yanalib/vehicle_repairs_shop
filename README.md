## Postman API Testing Examples

### 1. Добавяне на клиент (Add Client)
- Method: POST
- URL: http://127.0.0.1:8000/api/clients
- Body (JSON):
```
{
  "first_name": "Yana",
  "last_name": "Kirova",
  "email": "yanakirova1@gmail.com",
  "phone_number": "0884452077",
  "address": "Test"
}
```

### 2. Добавяне на автомобил към клиент (Add Vehicle to Client)
- Method: POST
- URL: http://127.0.0.1:8000/api/clients/{clientId}/vehicles
- Body (JSON):
```
{
  "reg_no": "CH9697BM",
  "make": "Volkswagen",
  "model": "Touareg",
  "year": 2020,
  "vin": "VIN1234567890"
}
```

### 3. Създаване на ремонтна поръчка (Create Repair Order)
- Method: POST
- URL: http://127.0.0.1:8000/api/repairs
- Body (JSON):
```
{
  "vehicle_id": 1,
  "description": "Смяна на масло",
  "status": "pending",
  "started_at": "2026-02-13 10:00:00",
  "finished_at": null,
  "total_cost": 120.00,
  "is_paid": false
}
```

### 4. Смяна на статус на поръчка (Change Repair Status)
- Method: PATCH
- URL: http://127.0.0.1:8000/api/repairs/{id}/status
- Body (JSON):
```
{
  "status": "completed"
}
```
