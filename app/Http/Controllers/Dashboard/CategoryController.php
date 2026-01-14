<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id',  Auth::id())->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
{
    try {
        $data['name'] = $request->name;
        $data['user_id'] = Auth::id();

        if ($request->hasFile('cover')) {
            // نفس فكرة SettingController
            $file = $request->file('cover');
            $path = $file->store('images/category', 'public');
            $data['cover'] = $path;
        }

        Category::create($data);

        Alert::success('success', 'category created successfully');
        return redirect()->route('categories.index');
    } catch (\Exception $exception) {
        Alert::error('error', 'category not created');
        return redirect()->back();
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
{
    try {
        $category = Category::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // تحديث الاسم
        $category->update($request->only(['name']));

        // لو في صورة جديدة
        if ($request->hasFile('cover')) {
            // نحذف القديمة لو موجودة
            if ($category->cover && \Storage::disk('public')->exists($category->cover)) {
                \Storage::disk('public')->delete($category->cover);
            }

            // نخزن الجديدة
            $file = $request->file('cover');
            $path = $file->store('images/category', 'public');
            $category->cover = $path;
            $category->save();
        }

        Alert::success('success', 'category updated successfully');
        return redirect()->route('categories.index');
    } catch (\Exception $exception) {
        Alert::error('error', 'category not updated');
        return redirect()->back();
    }
}


    /**
     * Remove the specified resource from storage.
     */
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
