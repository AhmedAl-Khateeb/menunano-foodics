<?php

namespace App\Services;

use App\Models\GoodsReceipt;
use App\Models\InventoryMovement;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function __construct(protected InventoryMovementService $movementService)
    {
    }

    public function postReceipt(GoodsReceipt $receipt): void
    {
        DB::transaction(function () use ($receipt) {
            foreach ($receipt->items as $item) {
                $material = RawMaterial::with('inventory')->findOrFail($item->raw_material_id);
                $inventory = $material->inventory;

                $this->movementService->move(
                    inventory: $inventory,
                    type: InventoryMovement::TYPE_PURCHASE,
                    quantity: (float) $item->quantity,
                    unitCost: (float) $item->unit_cost,
                    referenceType: GoodsReceipt::class,
                    referenceId: $receipt->id,
                    description: 'استلام شراء',
                    notes: 'استلام على الفاتورة ' . $receipt->receipt_number,
                    userId: $receipt->user_id,
                );

                $material->update([
                    'purchase_price' => $item->unit_cost,
                    'last_cost'      => $item->unit_cost,
                    'avg_cost'       => $item->unit_cost,
                ]);
            }

            $receipt->update(['status' => 'posted']);

            if ($receipt->purchaseOrder) {
                foreach ($receipt->items as $item) {
                    if ($item->purchaseOrderItem) {
                        $item->purchaseOrderItem->increment('received_quantity', $item->quantity);
                    }
                }

                $allReceived = $receipt->purchaseOrder->items()->whereColumn('received_quantity', '<', 'quantity')->doesntExist();

                $receipt->purchaseOrder->update([
                    'status' => $allReceived ? 'received' : 'partial_received',
                ]);
            }
        });
    }
}