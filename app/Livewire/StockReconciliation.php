<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;

class StockReconciliation extends Component
{
    public $searchQuery = '';
    public $items = [];

    // Map: [inventory_id => physical_count]
    public $physicalCounts = [];

    public function mount()
    {
        $this->loadInventory();
    }

    public function loadInventory()
    {
        $storeId = auth()->id();
        
        $query = Inventory::with(['inventoriable', 'unit'])
            ->where('user_id', $storeId);

        if (strlen($this->searchQuery) >= 2) {
            $query->whereHasMorph('inventoriable', '*', function ($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('sku', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $inventories = $query->get();

        $this->items = $inventories->map(function ($inv) {
            return [
                'id' => $inv->id,
                'name' => $inv->inventoriable->name ?? 'غير معروف',
                'sku' => $inv->inventoriable->sku ?? '-',
                'unit' => $inv->unit->name ?? 'وحدة',
                'system_qty' => floatval($inv->current_quantity),
            ];
        })->toArray();

        // Initialize physical counts if not set
        foreach ($this->items as $item) {
            if (!isset($this->physicalCounts[$item['id']])) {
                $this->physicalCounts[$item['id']] = $item['system_qty'];
            }
        }
    }

    public function updatedSearchQuery()
    {
        $this->loadInventory();
    }

    public function saveReconciliation()
    {
        $storeId = auth()->id();
        $adjustmentsMade = 0;

        try {
            DB::transaction(function () use ($storeId, &$adjustmentsMade) {
                foreach ($this->physicalCounts as $inv_id => $physical_count) {
                    // Skip empty or invalid input
                    if ($physical_count === '' || $physical_count === null) continue;
                    
                    $physical_count = floatval($physical_count);
                    
                    $inventory = Inventory::find($inv_id);
                    if (!$inventory) continue;

                    $system_qty = floatval($inventory->current_quantity);
                    $difference = $physical_count - $system_qty;

                    // If there's a difference, adjust it
                    if (round($difference, 3) != 0) {
                        $inventory->current_quantity = $physical_count;
                        $inventory->save();

                        // Log movement
                        InventoryMovement::create([
                            'inventory_id' => $inventory->id,
                            'type' => $difference > 0 ? 'in' : 'out', // Determine type
                            'quantity' => abs($difference),
                            'previous_quantity' => $system_qty,
                            'new_quantity' => $physical_count,
                            'reference_type' => 'Reconciliation',
                            'reference_id' => 0, // No specific reference ID, just a general adjustment
                            'notes' => 'تسوية جرد دوري (' . ($difference > 0 ? 'فائض' : 'عجز') . ')',
                            'created_by' => $storeId,
                        ]);

                        $adjustmentsMade++;
                    }
                }
            });

            if ($adjustmentsMade > 0) {
                session()->flash('success', "تم تنفيذ التسوية الجردية وتحديث $adjustmentsMade من الأصناف بنجاح.");
            } else {
                session()->flash('info', "لم يتم العثور على أي فروقات. جميع الأرصدة مطابقة.");
            }

            // Reload data
            $this->loadInventory();

        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إجراء التسوية: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.stock-reconciliation');
    }
}
