<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InventoryMovementService
{
    public function move(
        Inventory $inventory,
        string $type,
        float $quantity,
        ?float $unitCost = null,
        ?string $referenceType = null,
        $referenceId = null,
        ?string $description = null,
        ?string $notes = null,
        ?int $userId = null
    ): InventoryMovement {
        if (round($quantity, 3) == 0) {
            throw new InvalidArgumentException('الكمية لا يمكن أن تكون صفر.');
        }

        return DB::transaction(function () use (
            $inventory,
            $type,
            $quantity,
            $unitCost,
            $referenceType,
            $referenceId,
            $description,
            $notes,
            $userId
        ) {
            $before = (float) $inventory->current_quantity;
            $after = $before + $quantity;

            if ($after < 0) {
                throw new InvalidArgumentException('لا يمكن أن يصبح رصيد المخزون بالسالب.');
            }

            $cost = $unitCost ?? (float) ($inventory->avg_cost ?: $inventory->purchase_price ?: 0);

            $movement = InventoryMovement::create([
                'user_id'        => $userId ?? auth()->id(),
                'inventory_id'   => $inventory->id,
                'type'           => $type,
                'quantity'       => $quantity,
                'unit_cost'      => $cost,
                'total_cost'     => abs($quantity) * $cost,
                'balance_before' => $before,
                'balance_after'  => $after,
                'reference_type' => $referenceType,
                'reference_id'   => $referenceId,
                'description'    => $description,
                'notes'          => $notes,
                'movement_date'  => now(),
            ]);

            $inventory->update([
                'current_quantity' => $after,
                'last_cost'        => $cost,
            ]);

            return $movement;
        });
    }
}