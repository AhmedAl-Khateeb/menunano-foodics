<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\ProductRecipe;
use Illuminate\Http\Request;

class CompositeItemController extends Controller
{
    public function index()
    {
        $products = Product::where('type', 'manufactured')
            ->where('user_id', auth()->id())
            ->with(['category', 'inventory.unit', 'recipes.ingredient'])
            ->latest()
            ->paginate(12);

        $categories = Category::where('user_id', auth()->id())->get();

        return view('dashboard.inventory.composite.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        $units = Unit::active()->get();
        $rawMaterials = Product::where('type', 'raw')->where('user_id', auth()->id())->get();
        return view('dashboard.inventory.composite.create', compact('categories', 'units', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'type' => 'manufactured',
        ]);

        return redirect()->route('inventory.composite.recipe.edit', $product->id)
            ->with('success', 'تم إضافة المنتج المركب بنجاح. يمكنك الآن إضافة مكونات الوصفة.');
    }

    public function editRecipe(Request $request, $id)
    {
        $product = Product::where('user_id', auth()->id())
            ->where('type', 'manufactured')
            ->with(['sizes'])
            ->findOrFail($id);
            
        $selectedSizeId = $request->query('size_id');
        
        $product->load(['recipes' => function($query) use ($selectedSizeId) {
            if ($selectedSizeId) {
                $query->where(function($q) use ($selectedSizeId) {
                    $q->where('product_size_id', $selectedSizeId)
                      ->orWhereNull('product_size_id');
                });
            } else {
                $query->whereNull('product_size_id');
            }
            $query->with(['ingredient.inventory.unit', 'unit', 'size']);
        }]);
        
        $rawMaterials = Product::where('type', 'raw')
            ->where('user_id', auth()->id())
            ->with('inventory.unit')
            ->get();
            
        $units = Unit::active()->get();
        
        return view('dashboard.inventory.composite.recipe', compact('product', 'rawMaterials', 'units', 'selectedSizeId'));
    }

    public function addIngredient(Request $request, $id)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.001',
            'unit_id' => 'required|exists:units,id',
            'product_size_id' => 'nullable|exists:product_sizes,id',
        ]);

        $product = Product::where('user_id', auth()->id())
            ->where('type', 'manufactured')
            ->findOrFail($id);

        $productSizeId = $request->filled('product_size_id') ? $request->product_size_id : null;

        // Check if ingredient already exists in recipe for this size (or no size)
        $exists = ProductRecipe::where('product_id', $product->id)
            ->where('ingredient_id', $request->ingredient_id)
            ->where('product_size_id', $productSizeId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'هذا المكون موجود بالفعل في الوصفة لهذا الحجم (أو الحجم المشترك).');
        }

        ProductRecipe::create([
            'product_id' => $product->id,
            'ingredient_id' => $request->ingredient_id,
            'quantity' => $request->quantity,
            'unit_id' => $request->unit_id,
            'product_size_id' => $productSizeId,
        ]);

        return back()->with('success', 'تم إضافة المكون للوصفة بنجاح.');
    }

    public function removeIngredient($recipe_id)
    {
        $recipe = ProductRecipe::whereHas('product', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($recipe_id);

        $recipe->delete();

        return back()->with('success', 'تم حذف المكون من الوصفة.');
    }

    public function edit($id)
    {
        $product = Product::where('user_id', auth()->id())->where('type', 'manufactured')->findOrFail($id);
        $categories = Category::where('user_id', auth()->id())->get();
        return view('dashboard.inventory.composite.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required_with:sizes|string|max:255',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
        ]);

        $product = Product::where('user_id', auth()->id())->where('type', 'manufactured')->findOrFail($id);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
        ]);

        // Handle Sizes Synchronization
        if ($request->has('sizes')) {
            $providedSizeIds = collect($request->sizes)->pluck('id')->filter()->toArray();
            
            // Delete sizes not present in request
            $product->sizes()->whereNotIn('id', $providedSizeIds)->delete();

            foreach ($request->sizes as $sizeData) {
                if (isset($sizeData['id'])) {
                    // Update existing size
                    $product->sizes()->where('id', $sizeData['id'])->update([
                        'size' => $sizeData['size'],
                        'price' => $sizeData['price'],
                    ]);
                } else {
                    // Create new size
                    $product->sizes()->create([
                        'size' => $sizeData['size'],
                        'price' => $sizeData['price'],
                    ]);
                }
            }
        } else {
            // Only clear if 'sizes' key is explicitly present but empty
            if ($request->has('sizes')) {
                $product->sizes()->delete();
            }
        }

        return redirect()->route('inventory.composite.index')->with('success', 'تم تعديل المنتج المركب بنجاح');
    }
}
