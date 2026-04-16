<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Facades\DB;

class PackageService
{
    public function index()
    {
        return Package::with(['features', 'businessType'])->latest()->get();
    }

    public function store(array $data): Package
    {
        return DB::transaction(function () use ($data) {
            $package = Package::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'duration' => $data['duration'],
                'is_active' => $data['is_active'] ?? false,
                'business_type_id' => $data['business_type_id'],
            ]);

            $this->syncFeatures($package, $data['features'] ?? []);

            return $package;
        });
    }

    public function update(Package $package, array $data): Package
    {
        return DB::transaction(function () use ($package, $data) {
            $package->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'duration' => $data['duration'],
                'is_active' => $data['is_active'] ?? false,
                'business_type_id' => $data['business_type_id'],
            ]);

            $package->features()->delete();
            $this->syncFeatures($package, $data['features'] ?? []);

            return $package;
        });
    }

    public function delete(Package $package): bool
    {
        return DB::transaction(function () use ($package) {
            $package->features()->delete();

            return $package->delete();
        });
    }

    private function syncFeatures(Package $package, array $features = []): void
    {
        foreach ($features as $feature) {
            if (!empty($feature)) {
                $package->features()->create([
                    'text' => $feature,
                ]);
            }
        }
    }
}
