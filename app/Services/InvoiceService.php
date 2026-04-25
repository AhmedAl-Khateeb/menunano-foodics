<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InvoiceService
{
    public function getPosInvoices(int $perPage = 20): LengthAwarePaginator
    {
        $storeOwnerId = StoreService::getStoreOwnerId();

        return Order::with(['customer', 'table'])
            ->where('user_id', $storeOwnerId)
            ->where('source', 'pos')
            ->latest()
            ->paginate($perPage);
    }

    public function getInvoiceForPrint(Order $order): Order
    {
        $storeOwnerId = StoreService::getStoreOwnerId();

        abort_if($order->user_id != $storeOwnerId, 403);

        return $order->load([
            'customer',
            'table',
            'deliveryMan',
            'items.product',
        ]);
    }
}