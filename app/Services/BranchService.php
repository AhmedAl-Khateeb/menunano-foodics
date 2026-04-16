<?php

namespace App\Services;

use App\Models\Branch;

class BranchService
{
    public function index()
    {
        return Branch::withCount('users')
        ->where('created_by', auth('web')->id())
            ->latest()
            ->paginate(10);
    }

    public function store($data)
    {
        return Branch::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'is_active' => $data['is_active'] ?? true,
            'created_by' => auth('web')->id(),
        ]);
    }

    public function update($data, $id)
    {
        $branch = Branch::findOrFail($id);
        abort_unless($branch->created_by === auth('web')->id(), 403);

        $branch->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $branch;
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        abort_unless($branch->created_by === auth('web')->id(), 403);
        $branch->delete();

        return $branch;
    }
}
