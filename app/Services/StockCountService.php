<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\StockCount;
use Illuminate\Support\Facades\DB;

class StockCountService
{
    public function __construct(protected InventoryMovementService $movementService)
    {
    }

    public function approve(StockCount $stockCount): void
    {
        DB::transaction(function () use ($stockCount) {
            foreach ($stockCount->items()->with('inventory')->get() as $item) {
                $difference = round((float) $item->physical_quantity - (float) $item->system_quantity, 3);

                if ($difference == 0) {
                    continue;
                }

                $this->movementService->move(
                    inventory: $item->inventory,
                    type: InventoryMovement::TYPE_ADJUSTMENT,
                    quantity: $difference,
                    referenceType: StockCount::class,
                    referenceId: $stockCount->id,
                    description: 'تسوية جرد',
                    notes: $difference > 0 ? 'فائض جرد' : 'عجز جرد',
                    userId: $stockCount->user_id,
                );
            }

            $stockCount->update([
                'status'      => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });
    }
}