<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PurchaseInvoiceForm extends Component
{
    public $suppliers = [];
    public $supplier_id;
    public $invoice_number = '';
    public $due_date = '';
    public $notes = '';
    public $paid_amount = 0;

    // Search properties
    public $searchQuery = '';
    public $searchResults = [];

    // Cart / Items
    // Structure: ['inventory_id' => 1, 'name' => 'Tomato', 'unit' => 'kg', 'quantity' => 1, 'unit_price' => 10, 'total' => 10]
    public $items = [];

    public function mount()
    {
        $storeId = auth()->id();
        $this->suppliers = Supplier::where('user_id', $storeId)->where('is_active', true)->get();
        // Default today's date
        $this->due_date = now()->format('Y-m-d');
    }

    // public function updatedSearchQuery()
    // {
    //     if (strlen($this->searchQuery) < 2) {
    //         $this->searchResults = [];

    //         return;
    //     }

    //     $storeId = auth()->id();

    //     // Search inventory items
    //     $this->searchResults = Inventory::with(['inventoriable', 'unit'])
    //         ->where('user_id', $storeId)
    //         ->whereHasMorph('inventoriable', '*', function ($query) {
    //             $query->where('name', 'like', '%'.$this->searchQuery.'%')
    //                   ->orWhere('sku', 'like', '%'.$this->searchQuery.'%');
    //         })
    //         ->take(10)
    //         ->get()
    //         ->map(function ($inventory) {
    //             return [
    //                 'id' => $inventory->id,
    //                 'name' => $inventory->inventoriable->name,
    //                 'sku' => $inventory->inventoriable->sku ?? '-',
    //                 'unit' => $inventory->unit->name ?? 'وحدة',
    //                 'purchase_price' => $inventory->purchase_price ?? 0,
    //             ];
    //         })->toArray();
    // }

    public function updatedSearchQuery()
    {
        if (strlen($this->searchQuery) < 2) {
            $this->searchResults = [];

            return;
        }

        $storeId = auth()->id();
        $inventories = Inventory::with(['inventoriable', 'unit'])
            ->where('user_id', $storeId)
            ->whereHasMorph(
                'inventoriable',
                '*',
                function ($query) {
                    $query->where('name', 'like', '%'.$this->searchQuery.'%');
                }
            )

            ->take(10)
            ->get();

        $this->searchResults = $inventories->map(function ($inventory) {
            if (!$inventory->inventoriable) {
                return null;
            }

            return [
                'id' => $inventory->id,
                'name' => $inventory->inventoriable->name,
                'type' => class_basename($inventory->inventoriable_type),
                'unit' => $inventory->unit->name ?? 'وحدة',
                'purchase_price' => $inventory->purchase_price
                    ?? $inventory->inventoriable->Purchase_price
                    ?? $inventory->inventoriable->price
                    ?? 0,
                'selling_price' => $inventory->inventoriable->selling_price ?? 0,
            ];
        })->filter()
          ->values()
          ->toArray();
    }

    public function addItem(int $inventoryId)
    {
        $inventory = Inventory::with(['inventoriable', 'unit'])
            ->find($inventoryId);

        if (!$inventory) {
            return;
        }

        // لو المنتج موجود بالفعل زود الكمية
        foreach ($this->items as $index => $item) {
            if ($item['inventory_id'] == $inventory->id) {
                ++$this->items[$index]['quantity'];

                $this->calculateItemTotal($index);

                $this->searchQuery = '';
                $this->searchResults = [];

                return;
            }
        }

        // إضافة منتج جديد
        $this->items[] = [
            'inventory_id' => $inventory->id,
            'name' => $inventory->inventoriable->name,
            'unit' => $inventory->unit->name ?? 'وحدة',
            'quantity' => 1,
            'unit_price' => $inventory->purchase_price ?? 0,
            'total' => $inventory->purchase_price ?? 0,
        ];

        $this->searchQuery = '';
        $this->searchResults = [];
    }

    public function calculateItemTotal(string $index)
    {
        $qty = floatval($this->items[$index]['quantity']);
        $price = floatval($this->items[$index]['unit_price']);
        $this->items[$index]['total'] = $qty * $price;
        $this->calculateInvoiceTotal();
    }

    public function updatedItems($value,string $key)
    {
        // $key looks like "1.quantity" or "1.unit_price"
        $parts = explode('.', $key);
        if (count($parts) == 2) {
            $index = $parts[0];
            $this->calculateItemTotal($index);
        }
    }

    public function removeItem(int $index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateInvoiceTotal();
    }

    public function getInvoiceTotalProperty()
    {
        return array_sum(array_column($this->items, 'total'));
    }

    public function calculateInvoiceTotal()
    {
        // This is mainly to trigger re-renders if necessary, computed property handles logic
    }

    public function getStatusProperty()
    {
        $total = $this->invoiceTotal;
        $paid = floatval($this->paid_amount);

        if ($total == 0 || $paid == 0) {
            return 'unpaid';
        }
        if ($paid >= $total) {
            return 'paid';
        }

        return 'partial';
    }

    public function saveInvoice()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ], [
            'supplier_id.required' => 'يرجى اختيار المورد.',
            'items.required' => 'يرجى إضافة عناصر للفاتورة.',
        ]);

        try {
            DB::transaction(function () {
                $storeId = auth()->id();

                // 1. Create Purchase Invoice
                $invoice = PurchaseInvoice::create([
                    'user_id' => $storeId,
                    'supplier_id' => $this->supplier_id,
                    'branch_id' => auth()->user()->branch_id ?? null,
                    'invoice_number' => $this->invoice_number,
                    'total_amount' => $this->invoiceTotal,
                    'paid_amount' => $this->paid_amount,
                    'due_date' => $this->due_date,
                    'notes' => $this->notes,
                    'status' => $this->status,
                ]);

                // Update supplier balance (if not fully paid, supplier balance increases = business owes supplier)
                $supplier = Supplier::find($this->supplier_id);
                $remaining = $this->invoiceTotal - $this->paid_amount;
                // Positive balance means business owes supplier
                $supplier->balance += $remaining;
                $supplier->save();

                // 2. Add Items & Update Inventory
                foreach ($this->items as $item) {
                    PurchaseInvoiceItem::create([
                        'purchase_invoice_id' => $invoice->id,
                        'inventory_id' => $item['inventory_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total' => $item['total'],
                    ]);

                    // Increase Inventory Stock
                    $inventory = Inventory::find($item['inventory_id']);
                    $oldStock = $inventory->current_quantity;
                    $inventory->current_quantity += $item['quantity'];
                    // Update avg purchase price? Optional, keeping it simple for now or update it directly
                    $inventory->purchase_price = $item['unit_price'];
                    $inventory->save();

                    // Log Movement
                    InventoryMovement::create([
                        'inventory_id' => $inventory->id,
                        'user_id' => $storeId,
                        'branch_id' => auth()->user()->branch_id ?? null,
                        'type' => InventoryMovement::TYPE_PURCHASE, // IN movement
                        'quantity' => $item['quantity'],
                        'balance_before' => $oldStock,
                        'balance_after' => $inventory->current_quantity,
                        'reference_type' => PurchaseInvoice::class,
                        'reference_id' => $invoice->id,
                        'notes' => 'شراء فاتورة مستلمة بمورد: '.$supplier->name,
                        // 'created_by' => $storeId,
                    ]);
                }
            });

            session()->flash('success', 'تم حفظ فاتورة المشتريات وتحديث المخزون بنجاح.');

            return redirect()->route('purchases.index');
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء الحفظ: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.purchase-invoice-form');
    }
}
