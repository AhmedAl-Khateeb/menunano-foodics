<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Adjust stock for an inventory record.
     *
     * @param Inventory $inventory
     * @param string $type The type of movement: 'purchase', 'waste', 'adjustment'
     * @param float $quantity The quantity value from input
     * @param float|null $unitCost The cost per unit (for purchases)
     * @param string|null $description
     * @param int $userId
     * @return InventoryMovement
     * @throws \Exception
     */
    public function adjust(Inventory $inventory, string $type, float $quantity, ?float $unitCost = null, ?string $description = null, int $userId)
    {
        return DB::transaction(function () use ($inventory, $type, $quantity, $unitCost, $description, $userId) {
            $oldQuantity = $inventory->current_quantity;
            $quantityChange = 0;

            if ($type === 'waste') {
                // Waste always reduces stock
                $quantityChange = -abs($quantity);
            } elseif ($type === 'purchase') {
                // Purchase always adds stock
                $quantityChange = abs($quantity);
                
                // Update purchase price if provided
                if (!is_null($unitCost)) {
                    $inventory->purchase_price = $unitCost;
                }
            } elseif ($type === 'adjustment') {
                // Adjustment trusts the sign provided by user
                // If user enters -5, it deduction. If 5, it's addition.
                $quantityChange = $quantity;
            } else {
                throw new \Exception("Invalid movement type: {$type}");
            }

            $newQuantity = $oldQuantity + $quantityChange;

            if ($newQuantity < 0) {
                 throw new \Exception('لا يمكن أن يكون المخزون بالسالب (الكمية المخصومة أكبر من المتوفر)');
            }

            $inventory->current_quantity = $newQuantity;
            $inventory->save();

            return InventoryMovement::create([
                'user_id' => $userId,
                'inventory_id' => $inventory->id,
                'type' => $type,
                'quantity' => $quantityChange,
                'unit_cost' => $unitCost ?? $inventory->purchase_price ?? 0,
                'balance_before' => $oldQuantity,
                'balance_after' => $newQuantity,
                'description' => $description,
            ]);
        });
    }

    /**
     * Deduct stock for a manufactured item based on its recipe.
     *
     * @param \App\Models\ProductSize $productSize
     * @param int $quantity The quantity of the product being sold
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    public function deductCompositeStock(\App\Models\ProductSize $productSize, int $quantity, int $userId)
    {
        DB::transaction(function () use ($productSize, $quantity, $userId) {
            $product = $productSize->product;
            
            // Combine Common Ingredients (null size) and Specific Ingredients
            $commonRecipes = $product->recipes()->whereNull('product_size_id')->get();
            $specificRecipes = $productSize->recipes;
            
            $allRecipes = $commonRecipes->concat($specificRecipes);

            if ($allRecipes->isEmpty()) {
                return;
            }

            // 2. Loop through ingredients and deduct
            foreach ($allRecipes as $recipe) {
                $ingredient = $recipe->ingredient;
                if (!$ingredient || !$ingredient->inventory) continue;

                $totalNeeded = $recipe->quantity * $quantity;
                
                // Adjust ingredient stock
                $this->adjust(
                    $ingredient->inventory,
                    'waste', 
                    $totalNeeded,
                    null,
                    "Consumption for Order: {$product->name} ({$productSize->size}) x{$quantity}",
                    $userId
                );
            }
        });
    }
}
