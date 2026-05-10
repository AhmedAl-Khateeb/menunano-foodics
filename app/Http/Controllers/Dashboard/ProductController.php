<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
// use App\Http\Requests\ProductStoreRequest;
// use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\UploadImg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
      -> latest()->paginate();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  App\Http\UploadImg;
     * 

     */


     use UploadImg;   //  use Traits


    public function store(Request $request)
    {
        try {
            $data = $request->only(['name', 'description','Purchase_price','selling_price']);
            // if ($request->hasFile('cover')) {
            //     // نخزنها في مجلد products داخل public
            //     $data['cover'] = $request->file('cover')->store('products', 'public');
            // }



            if ($request->hasFile('cover')) {
            @$CoverNAME = $this->saveImage($request->cover, 'Attachfile/products');

            }

            $data['user_id'] = Auth::id();
            $product = Product::create($data + ['user_id' => Auth::id(), 
            'category_id' => $request->category_id,'cover' => $CoverNAME  ]);

            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $size) {
                    if (!empty($size['size']) || !empty($size['price'])) {
                        $product->sizes()->create([
                            'size' => $size['size'] ?? null,
                            'Purchase_price' => $size['Purchase_price'] ?? null,
                            'selling_price' => $size['selling_price'] ?? null,

                        ]);
                    }
                }
            }

            Alert::success('success', 'product created successfully');

            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            Alert::error('error', 'product not created');

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  App\Http\UploadImg;
     * 

     */


     use UploadImg;   //  use Traits

     
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $data = $request->only(['name', 'description','Purchase_price','selling_price']);

            // if ($request->hasFile('cover')) {
            //     // لو فيه صورة قديمة نحذفها
            //     if ($product->cover && Storage::disk('public')->exists($product->cover)) {
            //         Storage::disk('public')->delete($product->cover);
            //     }

                // $data['cover'] = $request->file('cover')->store('products', 'public');




            //}

            if ($request->hasFile('cover')) {


            @$CoverNAME = $this->saveImage($request->cover, 'Attachfile/products');

            }else{

                @$CoverNAME =$product->cover;


            }


            $product->update($data + ['category_id' => $request->category_id,
        
        
        'cover' => $CoverNAME]);

            // Delete old sizes
            $product->sizes()->delete();

            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $size) {
                    if (!empty($size['size']) || !empty($size['price'])) {
                        $product->sizes()->create([
                            'size' => $size['size'] ?? null,
                            'Purchase_price' => $size['Purchase_price'] ?? null,
                            'selling_price' => $size['selling_price'] ?? null,

                        ]);
                    }
                }
            }
            Alert::success('success', 'Product updated successfully');

            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            Alert::error('error', 'Product not updated');

            return redirect()->back();
        }
    }

    public function show(Product $product)
    {
        return view('products.sizes', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
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
