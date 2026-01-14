<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\ApiResponse;
use App\Models\Social;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $socials = Social::select('id', 'name', 'url')->get();
        return ApiResponse::success($socials);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
            'url' => 'required|array',
            'url.*' => 'required|string|max:255',
            'icon' => 'required|array',
            'icon.*' => 'nullable|string|max:255',
        ]);

        $data = [];
        foreach ($request->name as $index => $name) {
            $data[] = [
                'name' => $name,
                'url' => $request->url[$index] ?? null,
                'icon' => $request->icon[$index] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Social::insert($data);

        return ApiResponse::created($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $social = Social::findOrFail($id);

        $social->update([
            'name' => $request->name ?? $social->name,
            'url' => $request->url ?? $social->url,
            'icon' => $request->icon ?? $social->icon,
        ]);

        return ApiResponse::updated( $social);
    }

    public function destroy($id)
    {
        $social = Social::findOrFail($id);
        $social->delete();

        return ApiResponse::deleted();
    }
}
