<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
// use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\UploadImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    use UploadImg;   //  use Traits

    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
        ->select('name', 'id')
        ->get();
        $products = Product::with('category')
        ->where('user_id', Auth::id())
        ->when(request('category_id'), function ($q) {
            $q->where('category_id', request('category_id'));
        })
      ->latest()->paginate();

        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $CoverNAME = null;

            if ($request->hasFile('cover')) {
                $CoverNAME = $this->saveImage($request->cover, 'Attachfile/products');
            }

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'Purchase_price' => $request->Purchase_price,
                'selling_price' => $request->selling_price,
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'cover' => $CoverNAME,
            ]);

            if ($request->sizes) {
                foreach ($request->sizes as $size) {
                    $product->sizes()->create([
                        'size' => $size['size'] ?? null,
                        'Purchase_price' => $size['Purchase_price'] ?? null,
                        'selling_price' => $size['selling_price'] ?? null,
                    ]);
                }
            }

            Alert::success('success', 'product created successfully');

            return redirect()->route('products.index');
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getLine());
        }
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);

        try {
            $cover = $product->cover;

            if ($request->hasFile('cover')) {
                $cover = $this->saveImage($request->file('cover'), 'Attachfile/products');
            }

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'Purchase_price' => $request->Purchase_price,
                'selling_price' => $request->selling_price,
                'category_id' => $request->category_id,
                'cover' => $cover,
            ]);

            $product->sizes()->delete();

            if (is_array($request->sizes)) {
                foreach ($request->sizes as $size) {
                    if (!empty($size['size']) || !empty($size['Purchase_price']) || !empty($size['selling_price'])) {
                        $product->sizes()->create($size);
                    }
                }
            }

            Alert::success('تم التحديث', 'تم تحديث المنتج بنجاح');

            return redirect()->route('products.index');
        } catch (\Throwable $e) {
            Alert::error('خطأ', 'حدث خطأ أثناء التحديث');

            return redirect()->back();
        }
    }

    public function show(int $id)
    {
        $product = Product::with('sizes')
        ->where('user_id', Auth::id())
        ->findOrFail($id);

        return view('products.sizes', compact('product'));
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        try {
            if ($product->cover) {
                FileHandler::deleteFile($product->cover);
            }
            $product->delete();
            Alert::success('success', 'Product deleted successfully');

            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            Alert::error('error', 'Product not deleted');

            return redirect()->back();
        }
    }
}
