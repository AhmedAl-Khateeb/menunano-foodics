<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    public function __construct(private ImageManager $imageManager)
    {
    }

    public function index()
    {
        $categories = InventoryCategory::where('user_id', auth()->id())
            ->withCount('rawMaterials')
            ->latest()
            ->paginate(12);

        return view('dashboard.inventory.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover')) {
            $data['cover'] = $this->imageManager->uploadImage(
                'inventory_categories',
                $request->file('cover'),
                'public'
            );
        }

        InventoryCategory::create($data);

        return back()->with('success', 'تم إضافة فئة المخزون بنجاح');
    }

    public function update(Request $request, $id)
    {
        $category = InventoryCategory::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover')) {
            if ($category->cover) {
                $this->imageManager->deleteImage($category->cover, 'public');
            }

            $data['cover'] = $this->imageManager->uploadImage(
                'inventory_categories',
                $request->file('cover'),
                'public'
            );
        }

        $category->update($data);

        return back()->with('success', 'تم تعديل الفئة بنجاح');
    }

    public function destroy($id)
    {
        $category = InventoryCategory::where('user_id', auth()->id())->findOrFail($id);

        if ($category->rawMaterials()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الفئة لأنها مرتبطة بمواد مخزن');
        }

        if ($category->cover) {
            $this->imageManager->deleteImage($category->cover, 'public');
        }

        $category->delete();

        return back()->with('success', 'تم حذف الفئة بنجاح');
    }
}
