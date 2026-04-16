<?php

namespace App\Services;

use App\Models\BusinessType;

class BusinessTypeService
{
    public function index(array $filters = [])
    {
        return BusinessType::query()
        ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%$v%"))
        ->latest()->paginate(10);
    }

    public function store(array $data)
    {
        return BusinessType::create($data);
    }

    public function update(array $data, $id)
    {
        $businessType = BusinessType::findOrFail($id);
        $businessType->update($data);

        return $businessType;
    }

    public function delete($id)
    {
        $businessType = BusinessType::findOrFail($id);
        $businessType->delete();

        return $businessType;
    }
}
