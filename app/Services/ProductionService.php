<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\ProductionOrder;
use Illuminate\Support\Facades\DB;

class ProductionService
{
    public function __construct(protected InventoryMovementService $movementService)
    {
    }

    public function produce(ProductionOrder $order): void
    {
        DB::transaction(function () use ($order) {
            $totalCost = 0;

            foreach ($order->items()->with('rawMaterial.inventory')->get() as $item) {
                $inventory = $item->rawMaterial->inventory;
                $cost = (float) ($inventory->avg_cost ?: $inventory->purchase_price ?: 0);
                $qty = (float) $item->consumed_quantity;

                $this->movementService->move(
                    inventory: $inventory,
                    type: InventoryMovement::TYPE_PRODUCTION_OUT,
                    quantity: -1 * $qty,
                    unitCost: $cost,
                    referenceType: ProductionOrder::class,
                    referenceId: $order->id,
                    description: 'استهلاك خامات للإنتاج',
                    notes: 'أمر إنتاج ' . $order->production_number,
                    userId: $order->user_id,
                );

                $lineCost = $qty * $cost;

                $item->update([
                    'unit_cost'  => $cost,
                    'total_cost' => $lineCost,
                ]);

                $totalCost += $lineCost;
            }

            $outputMaterial = $order->recipe->outputMaterial;

            if ($outputMaterial && $outputMaterial->inventory) {
                $finishedUnitCost = $order->produced_quantity > 0
                    ? $totalCost / (float) $order->produced_quantity
                    : 0;

                $this->movementService->move(
                    inventory: $outputMaterial->inventory,
                    type: InventoryMovement::TYPE_PRODUCTION_IN,
                    quantity: (float) $order->produced_quantity,
                    unitCost: $finishedUnitCost,
                    referenceType: ProductionOrder::class,
                    referenceId: $order->id,
                    description: 'إضافة ناتج إنتاج',
                    notes: 'ناتج أمر إنتاج ' . $order->production_number,
                    userId: $order->user_id,
                );
            }

            $order->update([
                'status'     => 'produced',
                'total_cost' => $totalCost,
            ]);
        });
    }
}