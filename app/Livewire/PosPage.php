<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Shift;
use App\Services\StoreService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Session;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
class PosPage extends Component
{
    #[Url(as: 'q', history: true)]
    public $search = '';

    #[Url(as: 'cat', history: true)]
    public $activeCategoryId; // Filter by category

    #[Session]
    public $cart = [];
    public $total = 0;

    // Checkout Properties
    public $paidAmount = 0;
    public $changeAmount = 0;
    #[Session]
    public $paymentMethod = 'cash'; // Default, but checks IDs now
    public $paymentMethods = [];

    // Mobile & UI State
    #[Url(as: 'tab', history: true)]
    public $activeTab = 'products'; // 'products' or 'cart'
    public $showSizeModal = false;
    public $showResetModal = false;
    public $selectedProductId; // Changed from Model to ID
    public $modalQuantity = 1;
    public $modalSelectedSizeId;

    // Customer Properties
    public $customerPhone = '';
    public $customerName = '';
    public $selectedCustomerId;

    // Order Type Properties
    #[Session]
    public $orderType = 'takeaway'; // takeaway, table, free_seating, delivery
    public $selectedTableId;
    public $deliveryFee = 0;
    public $selectedDeliveryManId;
    public $tables = [];
    public $deliveryMen = [];

    // Shift Properties
    public $requiresShiftStart = false;
    public $shiftStartingCash = '';
    public $showEndShiftModal = false;
    public $shiftEndingCash = '';

    // Computed Property to fetch product safely
    public function getSelectedProductForSizeProperty()
    {
        if (!$this->selectedProductId) {
            return null;
        }

        return Product::with('sizes')->find($this->selectedProductId);
    }

    public function updatedCustomerPhone()
    {
        $this->selectedCustomerId = null;
        // Search by phone
        if (strlen($this->customerPhone) > 3) {
            $storeOwnerId = StoreService::getStoreOwnerId();
            $customer = \App\Models\Customer::where('user_id', $storeOwnerId)
                        ->where('phone', 'like', '%'.$this->customerPhone.'%')
                        ->first();

            if ($customer) {
                $this->selectedCustomerId = $customer->id;
                $this->customerName = $customer->name;
            } else {
                $this->customerName = ''; // Reset name for new entry
            }
        }
    }

    public function openResetModal()
    {
        $this->showResetModal = true;
    }

    public function closeResetModal()
    {
        $this->showResetModal = false;
    }

    public function confirmReset()
    {
        $this->cart = [];
        $this->paymentMethod = 'cash';
        $this->paidAmount = 0;
        $this->changeAmount = 0;
        $this->customerPhone = '';
        $this->customerName = '';
        $this->selectedCustomerId = null;
        $this->closeResetModal();
    }

    public function mount()
    {
        // Fetch dynamic payment methods
        $storeId = StoreService::getStoreOwnerId();
        $this->paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
                                ->where('created_by', $storeId)
                                ->get();

        // Fetch Tables with active orders
        $this->tables = \App\Models\Table::with(['diningArea', 'orders' => function ($q) {
            $q->where('status', 'pending');
        }])->where('user_id', $storeId)->where('is_active', true)->get();

        // Fetch Delivery Men
        $this->deliveryMen = \App\Models\DeliveryMan::where('user_id', $storeId)->where('is_active', true)->get();

        // Default payment method
        /** @var \App\Models\PaymentMethod $firstPaymentMethod */
        $firstPaymentMethod = $this->paymentMethods->first();
        if ($firstPaymentMethod) {
            $this->paymentMethod = $firstPaymentMethod->id;
        }

        if (request()->has('showEndShift') && request()->get('showEndShift') == 'true') {
            $this->showEndShiftModal = true;
        }

        $this->checkActiveShift();

        // Fix: Recalculate total if cart has items (persisted in session)
        if (!empty($this->cart)) {
            $this->calculateTotal();
        }
    }

    public function checkActiveShift()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (!$user) {
            return;
        }

        // If there's an active or paused shift for this user, they can proceed
        $activeShift = Shift::where('user_id', $user->id)
                        ->whereIn('status', ['active', 'paused'])
                        ->first();

        if (!$activeShift) {
            $this->requiresShiftStart = true;
        } else {
            $this->requiresShiftStart = false;
            // If it was paused, automatically resume it upon login/mounting POS
            if ($activeShift->status === 'paused') {
                $activeShift->update(['status' => 'active']);
            }
        }
    }

    public function startShift()
    {
        $this->validate([
            'shiftStartingCash' => 'required|numeric|min:0',
        ], [
            'shiftStartingCash.required' => 'يرجى إدخال مبلغ الدرج الافتتاحي',
            'shiftStartingCash.numeric' => 'يجب أن يكون المبلغ رقماً',
            'shiftStartingCash.min' => 'لا يمكن أن يكون المبلغ بالسالب',
        ]);

        $user = auth()->user();

        $storeOwnerId = StoreService::getStoreOwnerId();

        $branchId = $user->branch_id ?? null;

        if (!$branchId) {
            $branchId = Branch::where('created_by', $storeOwnerId)
                ->where('is_active', 1)
                ->value('id');
        }

        if (!$branchId) {
            session()->flash('error', 'لا يوجد فرع مرتبط بهذا المستخدم. يرجى إنشاء فرع أو ربط المستخدم بفرع.');

            return;
        }

        Shift::create([
            'user_id' => auth()->id(),
            'branch_id' => $branchId,
            'starting_cash' => $this->shiftStartingCash,
            'expected_cash' => $this->shiftStartingCash,
            'start_time' => now(),
            'status' => 'active',
        ]);

        $this->requiresShiftStart = false;
        $this->shiftStartingCash = '';
    }

    public function openEndShiftModal()
    {
        $this->shiftEndingCash = '';
        $this->showEndShiftModal = true;
    }

    public function closeEndShiftModal()
    {
        $this->showEndShiftModal = false;
    }

    public function endShift()
    {
        $this->validate([
            'shiftEndingCash' => 'required|numeric|min:0',
        ], [
            'shiftEndingCash.required' => 'يرجى إدخال مبلغ الدرج النهائي',
            'shiftEndingCash.numeric' => 'يجب أن يكون المبلغ رقماً',
            'shiftEndingCash.min' => 'لا يمكن أن يكون المبلغ بالسالب',
        ]);

        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($activeShift) {
            $endingCash = floatval($this->shiftEndingCash);
            $expectedCash = floatval($activeShift->expected_cash ?? $activeShift->starting_cash ?? 0);

            $activeShift->update([
                'ending_cash' => $endingCash,
                'cash_difference' => $endingCash - $expectedCash,
                'end_time' => now(),
                'status' => 'closed',
                'closed_by' => auth()->id(),
            ]);
        }

        $this->showEndShiftModal = false;
        $this->requiresShiftStart = true;
    }

    #[Layout('layouts.app')]
    #[Title('البيع السريع (POS)')]
    public function render()
    {
        $storeOwnerId = StoreService::getStoreOwnerId();

        // Fetch Categories
        $categories = \App\Models\Category::where('user_id', $storeOwnerId)->get();

        // Fetch Products
        $productsQuery = Product::where('user_id', $storeOwnerId)
                        ->where('name', 'like', '%'.$this->search.'%');

        if ($this->activeCategoryId) {
            $productsQuery->where('category_id', $this->activeCategoryId);
        }

        $products = $productsQuery->with('sizes')->latest()->get();

        return view('livewire.pos-page', [
            'products' => $products,
            'categories' => $categories,
            'cartProductIds' => collect($this->cart)->pluck('id')->toArray(),
        ]);
    }

    // Open Orders Interface
    public $showOpenOrdersModal = false;
    public $openOrders = [];
    public $selectedOpenOrderId;

    public function loadOpenOrders()
    {
        $storeId = StoreService::getStoreOwnerId();
        $this->openOrders = \App\Models\Order::with('table', 'customer')
            ->where('user_id', $storeId)
            ->whereIn('status', ['pending', 'dining'])
            ->orderBy('created_at', 'desc')
            ->get();
        $this->showOpenOrdersModal = true;
        $this->selectedOpenOrderId = null;
    }

    public function closeOpenOrdersModal()
    {
        $this->showOpenOrdersModal = false;
    }

    public function selectOpenOrderForPayment($orderId)
    {
        $this->selectedOpenOrderId = $orderId;
        $order = \App\Models\Order::find($orderId);
        if ($order) {
            $this->paidAmount = $order->total_price;
            $this->total = $order->total_price;
        }
    }

    public function payOpenOrder()
    {
        $order = \App\Models\Order::find($this->selectedOpenOrderId);

        if ($order) {
            if ($this->paymentMethod === 'cash' && $this->paidAmount < $order->total_price) {
                session()->flash('open_order_error', 'المبلغ المدفوع أقل من الإجمالي!');

                return;
            }

            $activeShift = Shift::where('user_id', auth()->id())
                ->where('status', 'active')
                ->latest()
                ->first();

            if (!$activeShift) {
                session()->flash('open_order_error', 'لا يوجد شيفت مفتوح لهذا المستخدم.');

                return;
            }

            $order->update([
                'shift_id' => $order->shift_id ?? $activeShift->id,
                'status' => 'served',
                'paid_amount' => $this->paidAmount,
                'change_amount' => max(0, $this->paidAmount - $order->total_price),
                'payment_method' => $this->paymentMethod,
            ]);

            $this->lastOrderId = $order->id;
            $this->closeOpenOrdersModal();
            $this->showSuccessModal = true;
        }
    }

    public function setCategory($id)
    {
        $this->activeCategoryId = $id === $this->activeCategoryId ? null : $id;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openSizeModal($productId)
    {
        $this->selectedProductId = $productId;
        $product = $this->selectedProductForSize;

        if ($product) {
            $this->modalQuantity = 1;
            if ($product->sizes->isNotEmpty()) {
                $this->modalSelectedSizeId = $product->sizes->first()->id;
            } else {
                $this->modalSelectedSizeId = null;
            }
            $this->showSizeModal = true;
        }
    }

    public function closeSizeModal()
    {
        $this->showSizeModal = false;
        $this->selectedProductId = null;
        $this->modalSelectedSizeId = null;
        $this->modalQuantity = 1;
    }

    public function selectSize($sizeId)
    {
        $this->modalSelectedSizeId = $sizeId;
    }

    public function incrementModalQuantity()
    {
        ++$this->modalQuantity;
    }

    public function decrementModalQuantity()
    {
        if ($this->modalQuantity > 1) {
            --$this->modalQuantity;
        }
    }

    public function confirmModalAddToCart()
    {
        $product = $this->selectedProductForSize;
        if (!$product) {
            return;
        }

        if ($product->sizes->isNotEmpty() && !$this->modalSelectedSizeId) {
            return;
        }

        $price = $product->price;
        $name = $product->name;
        $effectiveSizeId = null;
        $sizeName = null;

        if ($this->modalSelectedSizeId) {
            $size = $product->sizes->find($this->modalSelectedSizeId);
            if ($size) {
                $price = $size->price;
                $name = $product->name;
                $sizeName = $size->size;
                $effectiveSizeId = $size->id;
            }
        } elseif ($price <= 0 && $product->sizes->isNotEmpty()) {
            // validation fallback
        }

        $cartItemId = $product->id.($effectiveSizeId ? '-'.$effectiveSizeId : '');

        $found = false;
        foreach ($this->cart as $index => $item) {
            if (isset($item['cart_item_id']) && $item['cart_item_id'] === $cartItemId) {
                $this->cart[$index]['quantity'] += $this->modalQuantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->cart[] = [
                'cart_item_id' => $cartItemId,
                'id' => $product->id,
                'size_id' => $effectiveSizeId,
                'name' => $name,
                'size_name' => $sizeName,
                'price' => floatval($price),
                'quantity' => $this->modalQuantity,
                'cover' => $product->cover,
            ];
        }

        $this->calculateTotal();
        $this->closeSizeModal();
    }

    public function addToCart($productId, $sizeId = null)
    {
        $product = Product::with('sizes')->find($productId);
        if (!$product) {
            return;
        }

        if (is_null($sizeId) && $product->sizes->isNotEmpty()) {
            $this->openSizeModal($productId);

            return;
        }

        $price = $product->price;
        $name = $product->name;
        $effectiveSizeId = null;
        $sizeName = null;

        if ($sizeId) {
            $size = $product->sizes->find($sizeId);
            if ($size) {
                $price = $size->price;
                $name = $product->name;
                $sizeName = $size->size;
                $effectiveSizeId = $size->id;
            }
        } elseif ($price <= 0 && $product->sizes->isNotEmpty()) {
            $size = $product->sizes->first();
            $price = $size->price;
            $name = $product->name;
            $sizeName = $size->size;
            $effectiveSizeId = $size->id;
        }

        $cartItemId = $product->id.($effectiveSizeId ? '-'.$effectiveSizeId : '');

        foreach ($this->cart as $index => $item) {
            if (isset($item['cart_item_id']) && $item['cart_item_id'] === $cartItemId) {
                ++$this->cart[$index]['quantity'];
                $this->calculateTotal();
                $this->closeSizeModal();

                return;
            }
        }

        $this->cart[] = [
            'cart_item_id' => $cartItemId,
            'id' => $product->id,
            'size_id' => $effectiveSizeId,
            'name' => $name,
            'size_name' => $sizeName,
            'price' => floatval($price),
            'quantity' => 1,
            'cover' => $product->cover,
        ];
        $this->calculateTotal();
        $this->closeSizeModal();
    }

    public function increment($index)
    {
        ++$this->cart[$index]['quantity'];
        $this->calculateTotal();
    }

    public function decrement($index)
    {
        if ($this->cart[$index]['quantity'] > 1) {
            --$this->cart[$index]['quantity'];
        } else {
            $this->removeFromCart($index);
        }
        $this->calculateTotal();
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calculateTotal();
    }

    public function updatedPaidAmount()
    {
        $paid = floatval($this->paidAmount);
        $total = floatval($this->total);
        $this->changeAmount = ($paid >= $total) ? ($paid - $total) : 0;
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }

        if ($this->orderType === 'delivery') {
            $this->total += (float) $this->deliveryFee;
        }

        $this->updatedPaidAmount();
    }

    public function updatedOrderType()
    {
        $this->calculateTotal();
    }

    public function updatedDeliveryFee()
    {
        $this->calculateTotal();
    }

    public $showSuccessModal = false;
    public $lastOrderId;

    // ... (existing methods)

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'السلة فارغة!');

            return;
        }

        if ($this->orderType === 'table' && empty($this->selectedTableId)) {
            session()->flash('error', 'يرجى تحديد الطاولة!');

            return;
        }

        if ($this->orderType === 'delivery' && (empty($this->customerPhone) || empty($this->customerName))) {
            session()->flash('error', 'يرجى إدخال بيانات العميل (الهاتف والاسم) للتوصيل!');

            return;
        }

        $isDraft = in_array($this->orderType, ['table', 'free_seating']) && floatval($this->paidAmount) == 0;

        if (!$isDraft && $this->paymentMethod === 'cash' && $this->paidAmount < $this->total) {
            session()->flash('error', 'المبلغ المدفوع أقل من الإجمالي!');

            return;
        }

        $activeShift = Shift::where('user_id', auth()->id())
    ->where('status', 'active')
    ->latest()
    ->first();

        if (!$activeShift) {
            session()->flash('error', 'لا يوجد شيفت مفتوح لهذا المستخدم.');

            return;
        }

        // DB Transaction to ensure data integrity
        \Illuminate\Support\Facades\DB::transaction(function () use ($isDraft, $activeShift) {
            // Determine Store Owner ID
            $userId = auth()->id();
            $storeOwnerId = auth()->user()->role === 'super_admin' ? $userId : (auth()->user()->created_by ?? $userId);

            // Handle Customer (Find or Create)
            $finalCustomerId = $this->selectedCustomerId;

            if (!$finalCustomerId && !empty($this->customerPhone) && !empty($this->customerName)) {
                // Create New Customer
                $customer = \App\Models\Customer::create([
                    'user_id' => $storeOwnerId,
                    'name' => $this->customerName,
                    'phone' => $this->customerPhone,
                ]);
                $finalCustomerId = $customer->id;
            }

            // Handle Existing Table Order
            $order = null;
            if ($this->orderType === 'table' && $this->selectedTableId) {
                $order = \App\Models\Order::where('table_id', $this->selectedTableId)
                                          ->where('status', 'pending')
                                          ->where('user_id', $storeOwnerId)
                                          ->first();
            }

            $orderStatus = $isDraft ? 'pending' : 'served';

            if ($order) {
                // Append to existing Order
                $order->update([
                    'shift_id' => $order->shift_id ?? $activeShift->id,
                    'total_price' => $order->total_price + $this->total,
                    // If it's being paid now, update status and payment details
                    'status' => $orderStatus,
                    'payment_method' => $isDraft ? $order->payment_method : $this->paymentMethod,
                    'paid_amount' => $isDraft ? $order->paid_amount : $this->paidAmount,
                    'change_amount' => $isDraft ? $order->change_amount : $this->changeAmount,
                ]);
            } else {
                // Create New Order
                $order = \App\Models\Order::create([
                    'user_id' => $storeOwnerId,
                    'shift_id' => $activeShift->id,
                    'customer_id' => $finalCustomerId, // Linked Customer
                    'status' => $orderStatus,
                    'type' => $this->orderType,
                    'table_id' => $this->orderType === 'table' ? $this->selectedTableId : null,
                    'total_price' => $this->total,
                    'payment_method' => $isDraft ? null : $this->paymentMethod,
                    'source' => 'pos',
                    'paid_amount' => $isDraft ? 0 : $this->paidAmount,
                    'change_amount' => $isDraft ? 0 : $this->changeAmount,
                    'delivery_fee' => $this->orderType === 'delivery' ? $this->deliveryFee : 0,
                    'delivery_man_id' => $this->orderType === 'delivery' ? $this->selectedDeliveryManId : null,
                ]);
            }

            // Create Order Product Sizes (Pivot Table)
            foreach ($this->cart as $item) {
                $productSizeId = $item['size_id'];

                // Handle Simple Products (No Size Selected)
                if (!$productSizeId) {
                    // Check if any size exists or create default
                    $productSize = \App\Models\ProductSize::where('product_id', $item['id'])->first();

                    if (!$productSize) {
                        // Auto-create a default size for this product to satisfy DB constraints
                        $productSize = \App\Models\ProductSize::create([
                            'product_id' => $item['id'],
                            'size' => 'Standard',
                            'price' => $item['price'],
                        ]);
                    }
                    $productSizeId = $productSize->id;
                }

                \Illuminate\Support\Facades\DB::table('order_product_sizes')->insert([
                    'order_id' => $order->id,
                    'product_size_id' => $productSizeId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->lastOrderId = $order->id;
        });

        $this->showSuccessModal = true;
    }

    // Merge Tables Functionality
    public $showMergeModal = false;
    public $mergeSourceOrderId;
    public $mergeTargetTableId;

    public function openMergeModal($orderId)
    {
        $this->mergeSourceOrderId = $orderId;
        $this->mergeTargetTableId = null;
        $this->showMergeModal = true;
        // Close OpenOrdersModal while merging
        $this->showOpenOrdersModal = false;
    }

    public function closeMergeModal()
    {
        $this->showMergeModal = false;
        $this->mergeSourceOrderId = null;
        $this->mergeTargetTableId = null;
        // Re-open previous modal
        $this->loadOpenOrders();
        $this->showOpenOrdersModal = true;
    }

    public function mergeTable()
    {
        $this->validate([
            'mergeTargetTableId' => 'required|exists:tables,id',
        ], [
            'mergeTargetTableId.required' => 'يرجى اختيار طاولة للدمج إليها.',
        ]);

        $sourceOrder = \App\Models\Order::find($this->mergeSourceOrderId);
        if (!$sourceOrder || $sourceOrder->type !== 'table') {
            session()->flash('merge_error', 'طلب المصدر غير صالح للدمج.');

            return;
        }

        if ($sourceOrder->table_id == $this->mergeTargetTableId) {
            session()->flash('merge_error', 'لا يمكن دمج الطاولة مع نفسها.');

            return;
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $storeOwnerId = $user->role === 'super_admin' ? $user->id : ($user->getAttribute('created_by') ?? $user->id);

        // Find Target Order (if exists and pending)
        $targetOrder = \App\Models\Order::where('table_id', $this->mergeTargetTableId)
            ->where('status', 'pending')
            ->where('user_id', $storeOwnerId)
            ->first();

        \Illuminate\Support\Facades\DB::transaction(function () use ($sourceOrder, $targetOrder) {
            if ($targetOrder) {
                // Target has an active order, transfer items and update totals
                foreach ($sourceOrder->items as $item) {
                    \Illuminate\Support\Facades\DB::table('order_product_sizes')->insert([
                        'order_id' => $targetOrder->id,
                        'product_size_id' => $item->pivot->product_size_id,
                        'quantity' => $item->pivot->quantity,
                        'price' => $item->pivot->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $targetOrder->update([
                    'total_price' => $targetOrder->total_price + $sourceOrder->total_price,
                ]);
                $sourceOrder->items()->detach(); // clear items from source
                $sourceOrder->delete(); // delete the empty source order
            } else {
                // Target table is empty, simply move the table ID
                $sourceOrder->update([
                    'table_id' => $this->mergeTargetTableId,
                ]);
            }
        });

        $this->showMergeModal = false;
        $this->mergeSourceOrderId = null;
        $this->mergeTargetTableId = null;

        $this->loadOpenOrders();
        $this->showOpenOrdersModal = true;
        session()->flash('open_order_success', 'تم دمج الطاولات بنجاح.');
    }

    public function startNewOrder()
    {
        $this->cart = [];
        $this->total = 0;
        $this->paidAmount = 0;
        $this->changeAmount = 0;
        $this->customerPhone = '';
        $this->customerName = '';
        $this->selectedCustomerId = null;
        $this->lastOrderId = null;
        $this->showSuccessModal = false;
        $this->orderType = 'takeaway';
        $this->selectedTableId = null;
        $this->deliveryFee = 0;
        $this->selectedDeliveryManId = null;
        $this->activeTab = 'products';
    }

    public function selectTable($tableId)
    {
        if ($this->selectedTableId == $tableId) {
            $this->selectedTableId = null; // Toggle Off
            $this->startNewOrder();
            $this->orderType = 'table';

            return;
        }

        $this->selectedTableId = $tableId;
        $this->orderType = 'table';

        // Find if this table has a pending order
        $order = \App\Models\Order::with(['items.product', 'items.inventory', 'customer'])
            ->where('table_id', $tableId)
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $this->cart = [];
            foreach ($order->items as $item) {
                $product = $item->product;
                if (!$product) {
                    continue;
                }

                $this->cart[] = [
                    'cart_item_id' => $product->id.'-'.$item->pivot->product_size_id,
                    'id' => $product->id,
                    'size_id' => $item->pivot->product_size_id,
                    'name' => $product->name,
                    'size_name' => $item->size ?? 'Standard',
                    'price' => floatval($item->pivot->price),
                    'quantity' => $item->pivot->quantity,
                    'cover' => $product->cover,
                ];
            }

            if ($order->customer) {
                $this->customerName = $order->customer->name;
                $this->customerPhone = $order->customer->phone;
                $this->selectedCustomerId = $order->customer->id;
            }

            $this->total = $order->total_price;
            $this->paidAmount = $order->paid_amount;
            $this->changeAmount = $order->change_amount;
            $this->paymentMethod = $order->payment_method ?? 'cash';
        } else {
            // Empty Table -> Clear cart but keep table selected
            $this->cart = [];
            $this->calculateTotal();
            $this->customerPhone = '';
            $this->customerName = '';
            $this->selectedCustomerId = null;
        }
    }
}
