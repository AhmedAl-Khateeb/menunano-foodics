<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductBarcodeController extends Controller
{
    public function printAll(Request $request)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $qty = min($qty, 200);

        // إظهار السعر أو لا
        $showPrice = $request->boolean('show_price');

        $storeOwnerId = StoreService::getStoreOwnerId();

        $productId = $request->get('product_id');
        $sizeId = $request->get('size_id');

        $items = collect();

        $generator = new BarcodeGeneratorPNG();

        // إنشاء الباركود كصورة Base64
        $createBarcode = function ($code) use ($generator) {
            return base64_encode(
                $generator->getBarcode($code, $generator::TYPE_CODE_128)
            );
        };

        /*
        |--------------------------------------------------------------------------
        | طباعة Size واحد
        |--------------------------------------------------------------------------
        */
        if ($sizeId) {
            $size = ProductSize::with('product')
                ->where('id', $sizeId)
                ->whereHas('product', function ($q) use ($storeOwnerId) {
                    $q->where('user_id', $storeOwnerId);
                })
                ->firstOrFail();

            $barcodeValue = $size->barcode ?: $size->product->barcode;

            $items->push([
                'name' => $size->product->name.' - '.$size->size,
                'barcode' => $createBarcode($barcodeValue),
                'price' => ($size->selling_price ?? 0) > 0
                    ? $size->selling_price
                    : $size->price,
            ]);

            return view(
                'products.barcodes-print',
                compact('items', 'qty', 'showPrice')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | طباعة منتج واحد
        |--------------------------------------------------------------------------
        */
        if ($productId) {
            $product = Product::with('sizes')
                ->where('user_id', $storeOwnerId)
                ->findOrFail($productId);

            // لو المنتج له مقاسات
            if ($product->sizes->isNotEmpty()) {
                foreach ($product->sizes as $size) {
                    $barcodeValue = $size->barcode ?: $product->barcode;

                    $items->push([
                        'name' => $product->name.' - '.$size->size,
                        'barcode' => $createBarcode($barcodeValue),
                        'price' => ($size->selling_price ?? 0) > 0
                            ? $size->selling_price
                            : $size->price,
                    ]);
                }
            } else {
                // منتج عادي بدون مقاسات
                if ($product->barcode) {
                    $items->push([
                        'name' => $product->name,
                        'barcode' => $createBarcode($product->barcode),
                        'price' => ($product->selling_price ?? 0) > 0
                            ? $product->selling_price
                            : $product->price,
                    ]);
                }
            }

            return view(
                'products.barcodes-print',
                compact('items', 'qty', 'showPrice')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | طباعة كل المنتجات
        |--------------------------------------------------------------------------
        */
        $products = Product::with('sizes')
            ->where('user_id', $storeOwnerId)
            ->get();

        foreach ($products as $product) {
            // المنتجات التي لها مقاسات
            if ($product->sizes->isNotEmpty()) {
                foreach ($product->sizes as $size) {
                    $barcodeValue = $size->barcode ?: $product->barcode;

                    $items->push([
                        'name' => $product->name.' - '.$size->size,
                        'barcode' => $createBarcode($barcodeValue),
                        'price' => ($size->selling_price ?? 0) > 0
                            ? $size->selling_price
                            : $size->price,
                    ]);
                }
            } else {
                // منتج بدون مقاسات
                if (!$product->barcode) {
                    continue;
                }

                $items->push([
                    'name' => $product->name,
                    'barcode' => $createBarcode($product->barcode),
                    'price' => ($product->selling_price ?? 0) > 0
                        ? $product->selling_price
                        : $product->price,
                ]);
            }
        }

        return view(
            'products.barcodes-print',
            compact('items', 'qty', 'showPrice')
        );
    }
}
