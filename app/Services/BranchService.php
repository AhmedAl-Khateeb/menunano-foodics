<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchService
{
    public function index(Request $request)
    {
        $search = $request->search;

        return Branch::withCount('users')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('created_at', 'like', "%{$search}%");
            });
        })
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
