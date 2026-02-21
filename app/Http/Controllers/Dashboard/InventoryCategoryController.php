<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->where('type', 'internal')
            ->latest()
            ->paginate(10);
            
        return view('dashboard.inventory.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'user_id' => auth()->id(),
            'type' => 'internal', // Force internal type
            'is_active' => true,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['cover'] = basename($path);
        }

        Category::create($data);

        return back()->with('success', 'تم إضافة فئة المخزون بنجاح');
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('user_id', auth()->id())
            ->where('type', 'internal')
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->cover && Storage::disk('public')->exists('categories/' . $category->cover)) {
                Storage::disk('public')->delete('categories/' . $category->cover);
            }
            
            $path = $request->file('image')->store('categories', 'public');
            $data['cover'] = basename($path);
        }

        $category->update($data);

        return back()->with('success', 'تم تعديل الفئة بنجاح');
    }

    public function destroy($id)
    {
        $category = Category::where('user_id', auth()->id())
            ->where('type', 'internal')
            ->findOrFail($id);

        // Check availability logic if needed (e.g. if has products)
        if ($category->products()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الفئة لأنها تحتوي على منتجات');
        }

        if ($category->cover && Storage::disk('public')->exists('categories/' . $category->cover)) {
            Storage::disk('public')->delete('categories/' . $category->cover);
        }

        $category->delete();

        return back()->with('success', 'تم حذف الفئة بنجاح');
    }
}
