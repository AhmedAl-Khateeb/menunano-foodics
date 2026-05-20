<?php

namespace App\Traits;

use App\Models\Attendance;
use App\Models\BranchLink;
use App\Models\CashTransfer;
use App\Models\Charge;
use App\Models\DeliveryMan;
use App\Models\DiningArea;
use App\Models\GoodsReceipt;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\ProductionOrder;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Shift;
use App\Models\ShiftExpense;
use App\Models\StockCount;
use App\Models\Table;
use App\Models\TransferRequest;
use App\Models\User;

trait BranchTrait
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shiftExpenses()
    {
        return $this->hasMany(ShiftExpense::class);
    }

    public function cashTransfers()
    {
        return $this->hasMany(CashTransfer::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_users')
            ->withPivot([
                'role',
                'is_primary_manager',
                'can_manage_permissions',
                'permissions',
                'assigned_by',
            ])
            ->withTimestamps();
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'branch_users')
            ->wherePivotIn('role', ['owner', 'main_manager', 'manager'])
            ->withPivot([
                'role',
                'is_primary_manager',
                'can_manage_permissions',
                'permissions',
            ])
            ->withTimestamps();
    }

    public function primaryManager()
    {
        return $this->belongsToMany(User::class, 'branch_users')
            ->wherePivot('is_primary_manager', true)
            ->withPivot('role')
            ->limit(1);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function diningAreas()
    {
        return $this->hasMany(DiningArea::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function deliveryMen()
    {
        return $this->hasMany(DeliveryMan::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }

    public function transferRequests()
    {
        return $this->hasMany(TransferRequest::class);
    }

    public function stockCounts()
    {
        return $this->hasMany(StockCount::class);
    }

    public function productionOrders()
    {
        return $this->hasMany(ProductionOrder::class);
    }

    public function outgoingLinks()
    {
        return $this->hasMany(BranchLink::class, 'from_branch_id');
    }

    public function incomingLinks()
    {
        return $this->hasMany(BranchLink::class, 'to_branch_id');
    }

    public function linkedBranches()
    {
        return $this->belongsToMany(BranchLink::class, 'branch_links', 'from_branch_id', 'to_branch_id')
        ->withPivot(['type', 'is_active', 'business_id'])
        ->withTimestamps();
    }

    public function charges()
    {
        return $this->morphToMany(Charge::class, 'chargeable');
    }
}
