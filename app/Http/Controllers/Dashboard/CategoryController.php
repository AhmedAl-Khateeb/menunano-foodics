<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->with('parent')
            ->orderByRaw('COALESCE(parent_id, id)')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->get();

        $parentCategories = Category::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories', 'parentCategories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            $data['name'] = $request->name;
            $data['user_id'] = Auth::id();
            $data['parent_id'] = $request->parent_id ?: null;

            if ($data['parent_id']) {
                Category::where('id', $data['parent_id'])
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
            }

            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $path = $file->store('images/category', 'public');
                $data['cover'] = $path;
            }

            Category::create($data);

            Alert::success('success', 'category created successfully');

            return redirect()->route('categories.index');
        } catch (\Exception $exception) {
            Alert::error('error', 'category not created');

            return redirect()->back()->withInput();
        }
    }

    public function update(CategoryUpdateRequest $request, string $id)
    {
        try {
            $category = Category::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $parentId = $request->parent_id ?: null;

            if ($parentId == $category->id) {
                Alert::error('error', 'category cannot be parent of itself');

                return redirect()->back()->withInput();
            }

            if ($parentId) {
                Category::where('id', $parentId)
                    ->where('user_id', Auth::id())
                    ->where('id', '!=', $category->id)
                    ->firstOrFail();
            }

            $category->name = $request->name;
            $category->parent_id = $parentId;

            if ($request->hasFile('cover')) {
                if ($category->cover && Storage::disk('public')->exists($category->cover)) {
                    Storage::disk('public')->delete($category->cover);
                }

                $file = $request->file('cover');
                $path = $file->store('images/category', 'public');
                $category->cover = $path;
            }

            $category->save();

            Alert::success('success', 'category updated successfully');

            return redirect()->route('categories.index');
        } catch (\Exception $exception) {
            Alert::error('error', 'category not updated');

            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            if ($category->cover) {
                FileHandler::deleteFile($category->cover);
            }

            $category->delete();

            Alert::success('success', 'category deleted successfully');

            return redirect()->route('categories.index');
        } catch (\Exception $exception) {
            Alert::error('error', 'category not deleted');

            return redirect()->back();
        }
    }
}
