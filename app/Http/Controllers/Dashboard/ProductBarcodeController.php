<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Services\StoreService;
use Illuminate\Http\Request;

class ProductBarcodeController extends Controller
{
    public function printAll(Request $request)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $qty = min($qty, 200);

        $storeOwnerId = StoreService::getStoreOwnerId();

        $productId = $request->get('product_id');
        $sizeId = $request->get('size_id');

        $items = collect();

        // لو اختار حجم معين
        if ($sizeId) {
            $size = ProductSize::with('product')
                ->where('id', $sizeId)
                ->whereHas('product', function ($q) use ($storeOwnerId) {
                    $q->where('user_id', $storeOwnerId);
                })
                ->firstOrFail();

            if ($size->barcode) {
                $items->push([
                    'name' => $size->product->name.' - '.$size->size,
                    'barcode' => $size->barcode,
                    'price' => ($size->selling_price ?? 0) > 0 ? $size->selling_price : $size->price,
                ]);
            }

            return view('products.barcodes-print', compact('items', 'qty'));
        }

        // لو اختار منتج معين
        if ($productId) {
            $product = Product::with('sizes')
                ->where('user_id', $storeOwnerId)
                ->findOrFail($productId);

            if ($product->sizes->isNotEmpty()) {
                foreach ($product->sizes as $size) {
                    if (!$size->barcode) {
                        continue;
                    }

                    $items->push([
                        'name' => $product->name.' - '.$size->size,
                        'barcode' => $size->barcode,
                        'price' => ($size->selling_price ?? 0) > 0 ? $size->selling_price : $size->price,
                    ]);
                }
            } else {
                if ($product->barcode) {
                    $items->push([
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                        'price' => ($product->selling_price ?? 0) > 0 ? $product->selling_price : $product->price,
                    ]);
                }
            }

            return view('products.barcodes-print', compact('items', 'qty'));
        }

        // لو لم يحدد منتج: اطبع الكل
        $products = Product::with('sizes')
            ->where('user_id', $storeOwnerId)
            ->get();

        foreach ($products as $product) {
            if ($product->sizes->isNotEmpty()) {
                foreach ($product->sizes as $size) {
                    if (!$size->barcode) {
                        continue;
                    }

                    $items->push([
                        'name' => $product->name.' - '.$size->size,
                        'barcode' => $size->barcode,
                        'price' => ($size->selling_price ?? 0) > 0 ? $size->selling_price : $size->price,
                    ]);
                }
            } else {
                if (!$product->barcode) {
                    continue;
                }

                $items->push([
                    'name' => $product->name,
                    'barcode' => $product->barcode,
                    'price' => ($product->selling_price ?? 0) > 0 ? $product->selling_price : $product->price,
                ]);
            }
        }

        return view('products.barcodes-print', compact('items', 'qty'));
    }
}
