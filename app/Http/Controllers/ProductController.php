<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Facades\FileHandler;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\StoreHelper;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use StoreHelper;
    public function index($storeName)
    {
        // نجيب المستخدم على حسب store_name
        $user = $this->getUserByStoreName($storeName);

        // نفلتر المنتجات الخاصة بالمستخدم ده فقط
        // نفلتر المنتجات الخاصة بالمستخدم ده فقط 
                // والتي تتبع فئة من نوع منيو
        $products = Product::query()
            ->where('user_id', $user->id)
            ->whereHas('categories', function ($q) {
                $q->where('type', \App\Models\Category::TYPE_MENU);
            })
            ->with(['categories' => function ($q) {
                $q->where('type', \App\Models\Category::TYPE_MENU);
            }, 'sizes'])
            ->get();

        return ApiResponse::success(ProductResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = DB::transaction(function () use ($request) {

            $data = $request->only(['name', 'description', 'category_id']);

            if ($request->hasFile('cover')) {
                $data['cover'] = FileHandler::storeFile($request->file('cover'), null, $request->file('cover')->getClientOriginalExtension());
            }

            $product = Product::create($data);

            return $product;
        });

        return ApiResponse::created(new ProductResource($product));
    }

    /**
     * Display the specified resource.
     */
    public function show($storeName, string $id)
    {
        // نجيب المستخدم
        $user = $this->getUserByStoreName($storeName);

        // نجيب المنتج بشرط يكون مملوك للمستخدم ده
        $product = Product::with(['categories' => function ($q) {
                $q->where('type', \App\Models\Category::TYPE_MENU);
            }, 'sizes'])
            ->where('user_id', $user->id)
            ->whereHas('categories', function ($q) {
                $q->where('type', \App\Models\Category::TYPE_MENU);
            })
            ->findOrFail($id);

        return ApiResponse::success(new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = DB::transaction(function () use ($request, $id) {
            $product = Product::findOrFail($id);
            $product->update(
                $request->only([
                    'name',
                    'description',
                    'category_id'
                ])
            );

            if ($request->hasFile('cover')) {
                FileHandler::deleteFile($product->cover);
                $product->cover = FileHandler::storeFile(
                    $request->file('cover'),
                    null,
                    $request->file('cover')->getClientOriginalExtension()
                );
                $product->save();
            }

            return $product;
        });

        return ApiResponse::updated(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);
            if ($product->cover) {
                FileHandler::deleteFile($product->cover);
            }
            $product->delete();
        });
        return ApiResponse::deleted();
    }
}
