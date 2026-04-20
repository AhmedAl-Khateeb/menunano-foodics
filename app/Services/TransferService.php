<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\RawMaterial;
use App\Models\TransferRequest;
use Illuminate\Support\Facades\DB;

class TransferService
{
    public function __construct(protected InventoryMovementService $movementService)
    {
    }

    public function approve(TransferRequest $transfer): void
    {
        DB::transaction(function () use ($transfer) {
            foreach ($transfer->items as $item) {
                $material = RawMaterial::with('inventory')->findOrFail($item->raw_material_id);
                $inventory = $material->inventory;

                $qty = (float) ($item->sent_quantity > 0 ? $item->sent_quantity : $item->requested_quantity);
                $item->update(['sent_quantity' => $qty]);

                $this->movementService->move(
                    inventory: $inventory,
                    type: InventoryMovement::TYPE_TRANSFER_OUT,
                    quantity: -1 * $qty,
                    referenceType: TransferRequest::class,
                    referenceId: $transfer->id,
                    description: 'تحويل مخزني - صرف',
                    notes: 'من الفرع '.$transfer->from_branch_id.' إلى الفرع '.$transfer->to_branch_id,
                    userId: $transfer->user_id,
                );
            }

            $transfer->update(['status' => 'approved']);
        });
    }

    public function receive(TransferRequest $transfer): void
    {
        DB::transaction(function () use ($transfer) {
            foreach ($transfer->items as $item) {
                $material = RawMaterial::with('inventory')->findOrFail($item->raw_material_id);
                $inventory = $material->inventory;

                $qty = (float) ($item->received_quantity > 0 ? $item->received_quantity : $item->sent_quantity);
                $item->update(['received_quantity' => $qty]);

                $this->movementService->move(
                    inventory: $inventory,
                    type: InventoryMovement::TYPE_TRANSFER_IN,
                    quantity: $qty,
                    referenceType: TransferRequest::class,
                    referenceId: $transfer->id,
                    description: 'تحويل مخزني - استلام',
                    notes: 'استلام تحويل من الفرع '.$transfer->from_branch_id,
                    userId: $transfer->user_id,
                );
            }

            $transfer->update(['status' => 'received']);
        });
    }
}
