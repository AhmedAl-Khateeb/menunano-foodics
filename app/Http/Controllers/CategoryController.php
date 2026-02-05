<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Facades\FileHandler;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\StoreHelper;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use StoreHelper;

    public function index($storeName)
    {
        $user = $this->getUserByStoreName($storeName);

        $categories = Category::where('user_id', $user->id)
            ->where('type', Category::TYPE_MENU)
            ->get();

        return ApiResponse::success(CategoryResource::collection($categories));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = DB::transaction(function () use ($request) {

            $data['name'] = $request->name;
            if ($request->hasFile('cover')) {
                $data['cover'] = FileHandler::storeFile($request->file('cover'), null, $request->file('cover')->getClientOriginalExtension());
            }
            $category = Category::create($data);

            return $category;
        });

        return ApiResponse::created($category);
    }

    /**
     * Display the specified resource.
     */
    public function show($storeName, string $name)
    {
        $user = $this->getUserByStoreName($storeName);

        $category = Category::with(['products' => function($q) {
                $q->whereHas('categories', function($subQ) {
                     $subQ->where('type', Category::TYPE_MENU);
                });
            }])
            ->where('user_id', $user->id)
            ->where('name', $name)
            ->where('type', Category::TYPE_MENU)
            ->firstOrFail();

        return ApiResponse::success(new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = DB::transaction(function () use ($request, $id) {
            $category = Category::findOrFail($id);
            $category->update($request->only(['name']));

            if ($request->hasFile('cover')) {
                FileHandler::deleteFile($category->cover);
                $category->cover = FileHandler::storeFile($request->file('cover'), null, $request->file('cover')->getClientOriginalExtension());
                $category->save();
            }

            return $category;
        });

        return ApiResponse::updated($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $category = Category::findOrFail($id);
            if ($category->cover) {
                FileHandler::deleteFile($category->cover);
            }
            $category->delete();
        });
        return ApiResponse::deleted();
    }
}
