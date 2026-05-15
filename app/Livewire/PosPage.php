<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Shift;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Support\Facades\DB;
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

    public $businessTypeSlug = 'rest';

    public $availableOrderTypes = [
        'takeaway',
        'table',
        'free_seating',
        'delivery',
    ];

    // Shift Properties
    public $requiresShiftStart = false;
    public $shiftStartingCash = '';
    public $showEndShiftModal = false;
    public $shiftEndingCash = '';

    public $shiftExpectedCash = 0;
    public $shiftCashDifferencePreview = 0;
    public $shiftCloseNote = '';

    public $shiftStartingCashPreview = 0;
    public $shiftCashSalesPreview = 0;
    public $shiftExpensesPreview = 0;
    public $shiftTransfersPreview = 0;

    public $showShiftExpenseModal = false;
    public $expenseTitle = '';
    public $expenseAmount = '';
    public $expenseNotes = '';

    public $showCashTransferModal = false;
    public $transferAmount = '';
    public $transferNotes = '';

    public $suggestedStartingCash = 0;
    public $hasPreviousClosedShift = false;

    public $kitchenNote = '';

    // حالات المودال
    public $showAddDeliveryManModal = false;

    // بيانات المندوب الجديد
    public $newDeliveryManName;
    public $newDeliveryManPhone;
    public $newDeliveryManCommission = 0;

    public $deliveryOrders = [];

    public $order_note;
    public $payment_method;

    public $selectedOrder;

    protected $listeners = [
        'echo:orders,new-order' => 'handleNewOrder',
    ];

    public function handleNewOrder($data)
    {
        $this->loadDeliveryOrders();

        $this->dispatch('playSound'); // optional JS event
    }

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
        $storeOwnerId = StoreService::getStoreOwnerId();

        $phone = trim($this->customerPhone);

        // reset دائم
        $this->selectedCustomerId = null;
        $this->customerName = '';

        if ($phone === '') {
            return;
        }

        // 1) لو الرقم كامل (11 رقم مصر)
        if (strlen($phone) >= 11) {
            $customer = Customer::where('user_id', $storeOwnerId)
                ->where('phone', $phone)
                ->first();

            if ($customer) {
                $this->selectedCustomerId = $customer->id;
                $this->customerName = $customer->name;
            }

            return;
        }

        // 2) اقتراح فقط (بدون override للاسم النهائي)
        $suggest = Customer::where('user_id', $storeOwnerId)
            ->where('phone', 'like', $phone.'%')
            ->orderBy('id')
            ->first();

        // ⚠️ مهم: ما تعتبرش ده اسم نهائي
        if ($suggest) {
            $this->customerName = $suggest->name;
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

    // public function selectDeliveryOrder($orderId)
    // {
    //     $order = Order::with('items.product', 'paymentMethodRelation')
    //         ->find($orderId);

    //     if (!$order) {
    //         return;
    //     }

    //     // فتح الفاتورة (ده أهم سطر)
    //     $this->activeTab = 'cart';

    //     $this->orderType = 'delivery';

    //     $this->selectedOrder = $order;

    //     $this->customerName = $order->name;
    //     $this->customerPhone = $order->phone;
    //     $this->paymentMethod = $order->payment_method;

    //     $this->cart = [];

    //     foreach ($order->items as $item) {
    //         $this->cart[] = [
    //             'id' => $item->id,
    //             'name' => $item->product->name ?? '',
    //             'price' => $item->pivot->price,
    //             'quantity' => $item->pivot->quantity,
    //         ];
    //     }

    //     $this->calculateTotal();

    //     $order->status = 'served';
    //     $order->save();

    //     $this->loadDeliveryOrders();

    //     $this->dispatch('stopSound');
    // }

    public function approveAndOpenOrder($orderId)
{
    $order = Order::with(['items.product', 'customer', 'paymentMethodRelation'])
        ->findOrFail($orderId);

    // ✅ تثبيت البيانات قبل الفتح
    $order->update([
        'status' => 'served',
    ]);

    // تحديث الإشعارات
    $this->loadDeliveryOrders();

    // ⬇️ تحميل القيم للكاشير مباشرة (مهم جداً)
    $this->selectedCustomerId = $order->customer?->id;
    $this->customerName = $order->customer?->name;
    $this->customerPhone = $order->customer?->phone;

    $this->kitchenNote = $order->kitchen_note;

    $this->paymentMethod = $order->payment_method;

    $this->paidAmount = $order->paid_amount ?? $order->total_price;
    $this->changeAmount = $order->change_amount ?? 0;

    $this->orderType = $order->type ?? 'delivery';

    // ⬇️ فتح الفاتورة مباشرة
    $this->openDeliveryOrder($orderId);

    // UI events
    $this->dispatch('close-dropdown');
    $this->dispatch('stopSound');
}

    public function fillOrderToPos($order)
    {
        $this->activeTab = 'cart';

        $this->selectedOrderId = $order->id;

        $this->selectedCustomerId = $order->customer?->id;
        $this->customerName = $order->customer?->name;
        $this->customerPhone = $order->customer?->phone;

        $this->paymentMethod = $order->payment_method ?? 'cash';
        $this->orderType = $order->type ?? 'delivery';

        $this->cart = [];

        foreach ($order->items as $item) {
            $this->cart[] = [
                'cart_item_id' => uniqid(),
                'name' => $item->product?->name ?? '',
                'price' => $item->price,
                'quantity' => $item->quantity,
            ];
        }

        $this->calculateTotal();
    }

    public function openDeliveryOrder($orderId)
{
    $order = Order::with(['items.product', 'customer'])
        ->findOrFail($orderId);

    $this->activeTab = 'cart';

    // بيانات العميل (لا تعيد كتابة payment هنا)
    $this->selectedCustomerId = $order->customer?->id;
    $this->customerName = $order->customer?->name;
    $this->customerPhone = $order->customer?->phone;

    $this->kitchenNote = $order->kitchen_note;

    // ⚠️ مهم: خليه من الداتا مباشرة بدون relation
    $this->paymentMethod = $order->payment_method;

    $this->paidAmount = $order->paid_amount ?? 0;
    $this->changeAmount = $order->change_amount ?? 0;

    $this->orderType = $order->type ?? 'delivery';

    $this->cart = [];

    foreach ($order->items as $item) {
        $this->cart[] = [
            'id' => $item->product_size_id ?? $item->id,
            'cart_item_id' => uniqid(),
            'name' => $item->product?->name ?? '',
            'price' => $item->pivot->price ?? $item->price,
            'quantity' => $item->pivot->quantity ?? 1,
        ];
    }

    $this->calculateTotal();

    $this->loadDeliveryOrders();

    $this->dispatch('close-dropdown');
    $this->dispatch('stopSound');
}

    public function loadDeliveryOrders()
    {
        $this->deliveryOrders = Order::with(['paymentMethodRelation', 'customer'])
            ->where('type', 'delivery')
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();
    }

    public function mount()
    {
        $this->activeTab = request()->get('tab', 'products');

        $storeId = StoreService::getStoreOwnerId();

        // تحميل الأساسيات
        $this->loadBusinessType($storeId);
        $this->normalizeOrderType();

        // طرق الدفع ✅
        $this->paymentMethods = \App\Models\PaymentMethod::where('is_active', 1)
            ->where(function ($q) use ($storeId) {
                $q->where('created_by', $storeId)
                  ->orWhereNull('created_by');
            })
            ->orderBy('id')
            ->get();

        // الطاولات
        $this->tables = \App\Models\Table::with(['diningArea', 'orders' => function ($q) {
            $q->where('status', 'pending');
        }])
            ->where('user_id', $storeId)
            ->where('is_active', true)
            ->get();

        $this->paymentMethod = 'cash';

        // الشيفت
        $this->checkActiveShift();
        $this->loadSuggestedStartingCash();

        // الإشعارات
        $this->loadDeliveryOrders();

        // فتح الطلب (مهم يكون بعد كل حاجة)
        if ($orderId = request()->get('order_id')) {
            $this->openDeliveryOrder($orderId);
        }

        // مودال الإغلاق
        if (request()->boolean('showEndShift')) {
            $this->openEndShiftModal();
        }

        // إعادة الحساب
        if (!empty($this->cart)) {
            $this->calculateTotal();
        }
    }

    //   public function mount()
    // {
    //     $this->activeTab = request()->get('tab', 'products');

    //     $storeId = StoreService::getStoreOwnerId();

    //     // 1. تحميل البيانات الأساسية أولاً
    //     $this->loadBusinessType($storeId);
    //     $this->normalizeOrderType();

    //     $this->paymentMethods = \App\Models\PaymentMethod::where('is_active', 1)
    //         ->where(function ($q) use ($storeId) {
    //             $q->where('created_by', $storeId)
    //               ->orWhereNull('created_by');
    //         })
    //         ->orderBy('id')
    //         ->get();

    //     $this->tables = \App\Models\Table::with(['diningArea', 'orders' => function ($q) {
    //         $q->where('status', 'pending');
    //     }])
    //         ->where('user_id', $storeId)
    //         ->where('is_active', true)
    //         ->get();

    //     $this->paymentMethod = 'cash';

    //     $this->checkActiveShift();
    //     $this->loadSuggestedStartingCash();

    //     // 2. تحميل الإشعارات
    //     $this->loadDeliveryOrders();

    //     // 3. فتح الطلب بعد كل حاجة
    //     if ($orderId = request()->get('order_id')) {
    //         $this->openDeliveryOrder($orderId);
    //     }

    //     // 4. مودال الإغلاق
    //     if (request()->boolean('showEndShift')) {
    //         $this->openEndShiftModal();
    //     }

    //     // 5. إعادة الحساب
    //     if (!empty($this->cart)) {
    //         $this->calculateTotal();
    //     }
    // }

    public function checkActiveShift()
    {
        /** @var User $user */
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
        $user = auth()->user();

        $branchId = $this->getBranchIdForCurrentUser();

        if (!$branchId) {
            session()->flash('error', 'لا يوجد فرع مرتبط بهذا المستخدم. يرجى إنشاء فرع أو ربط المستخدم بفرع.');

            return;
        }

        $hasActiveShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->exists();

        if ($hasActiveShift) {
            session()->flash('error', 'يوجد شيفت مفتوح بالفعل لهذا المستخدم.');

            return;
        }

        $this->validate([
            'shiftStartingCash' => 'required|numeric|min:0',
        ], [
            'shiftStartingCash.required' => 'يرجى إدخال مبلغ الدرج الافتتاحي',
            'shiftStartingCash.numeric' => 'يجب أن يكون المبلغ رقماً',
            'shiftStartingCash.min' => 'لا يمكن أن يكون المبلغ بالسالب',
        ]);

        $startingCash = (float) $this->shiftStartingCash;

        $lastClosedShift = Shift::where('branch_id', $branchId)
            ->where('status', 'closed')
            ->whereNotNull('end_time')
            ->latest('end_time')
            ->first();

        $newShift = Shift::create([
            'user_id' => auth()->id(),
            'branch_id' => $branchId,
            'starting_cash' => $startingCash,
            'expected_cash' => $startingCash,
            'start_time' => now(),
            'status' => 'active',
        ]);

        // ربط حركة الترحيل القديمة بالشيفت الجديد
        if ($lastClosedShift && class_exists(\App\Models\CashTransfer::class)) {
            \App\Models\CashTransfer::where('from_shift_id', $lastClosedShift->id)
                ->where('type', 'to_next_shift')
                ->whereNull('to_shift_id')
                ->latest()
                ->first()?->update([
                    'to_shift_id' => $newShift->id,
                    'to_user_id' => auth()->id(),
                ]);
        }

        $this->requiresShiftStart = false;
        $this->shiftStartingCash = '';
    }

    private function getBranchIdForCurrentUser()
    {
        $user = auth()->user();

        $storeOwnerId = StoreService::getStoreOwnerId();

        $branchId = $user->branch_id ?? null;

        if (!$branchId) {
            $branchId = Branch::where('created_by', $storeOwnerId)
                ->where('is_active', 1)
                ->value('id');
        }

        return $branchId;
    }

    private function loadSuggestedStartingCash()
    {
        $this->suggestedStartingCash = 0;
        $this->shiftStartingCash = '';
        $this->hasPreviousClosedShift = false;
    }

    // دفع الكاش
    public function selectCashPayment()
    {
        $this->paymentMethod = 'cash';
        $this->paidAmount = (float) $this->total;
        $this->updatedPaidAmount();
    }

    public function selectPaymentMethod($methodId)
    {
        $this->paymentMethod = (string) $methodId;
        $this->paidAmount = (float) $this->total;
        $this->changeAmount = 0;
    }

    public function openEndShiftModal()
    {
        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$activeShift) {
            session()->flash('error', 'لا يوجد شيفت مفتوح لهذا المستخدم.');

            return;
        }

        $shiftService = app(\App\Services\ShiftService::class);

        $this->shiftStartingCashPreview = (float) $activeShift->starting_cash;
        $this->shiftCashSalesPreview = $shiftService->calculateCashSalesForShift($activeShift);
        $this->shiftExpensesPreview = $shiftService->calculateExpensesForShift($activeShift);
        $this->shiftTransfersPreview = $shiftService->calculateTransfersToManagerForShift($activeShift);

        $this->shiftExpectedCash = $shiftService->calculateExpectedCashForShift($activeShift);

        $this->shiftEndingCash = $this->shiftExpectedCash;
        $this->shiftCashDifferencePreview = 0;
        $this->shiftCloseNote = '';
        $this->resetErrorBag();

        $this->showEndShiftModal = true;
    }

    public function updatedShiftEndingCash()
    {
        $this->shiftCashDifferencePreview =
            (float) $this->shiftEndingCash - (float) $this->shiftExpectedCash;
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
            ->latest()
            ->first();

        if (!$activeShift) {
            session()->flash('error', 'لا يوجد شيفت مفتوح لهذا المستخدم.');

            return;
        }

        $difference = (float) $this->shiftEndingCash - (float) $this->shiftExpectedCash;

        if ($difference != 0 && empty($this->shiftCloseNote)) {
            $this->addError('shiftCloseNote', 'يوجد فرق في الدرج، يرجى كتابة سبب الفرق أو مراجعة الرقم قبل الإغلاق.');

            return;
        }

        app(\App\Services\ShiftService::class)->closeShift($activeShift, [
            'ending_cash' => $this->shiftEndingCash,
            'notes' => $this->shiftCloseNote,
        ]);

        $this->showEndShiftModal = false;

        return redirect()->route('pos.shift.closing-reipt', $activeShift->id);
    }

    public function openShiftExpenseModal()
    {
        $this->expenseTitle = '';
        $this->expenseAmount = '';
        $this->expenseNotes = '';
        $this->resetErrorBag();

        $this->showShiftExpenseModal = true;
    }

    public function closeShiftExpenseModal()
    {
        $this->showShiftExpenseModal = false;
    }

    public function saveShiftExpense()
    {
        $this->validate([
            'expenseTitle' => 'required|string|max:255',
            'expenseAmount' => 'required|numeric|min:0.5',
            'expenseNotes' => 'nullable|string',
        ], [
            'expenseTitle.required' => 'يرجى إدخال اسم المصروف',
            'expenseAmount.required' => 'يرجى إدخال قيمة المصروف',
            'expenseAmount.numeric' => 'قيمة المصروف يجب أن تكون رقمًا',
            'expenseAmount.min' => 'قيمة المصروف يجب أن تكون أكبر من صفر',
        ]);

        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$activeShift) {
            session()->flash('error', 'لا يوجد شيفت مفتوح لهذا المستخدم.');

            return;
        }

        \App\Models\ShiftExpense::create([
            'shift_id' => $activeShift->id,
            'user_id' => auth()->id(),
            'branch_id' => $activeShift->branch_id,
            'title' => $this->expenseTitle,
            'amount' => $this->expenseAmount,
            'expense_date' => now(),
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'notes' => $this->expenseNotes,
        ]);

        $this->showShiftExpenseModal = false;

        session()->flash('success', 'تم تسجيل المصروف بنجاح.');
    }

    public function openCashTransferModal()
    {
        $this->transferAmount = '';
        $this->transferNotes = '';
        $this->resetErrorBag();

        $this->showCashTransferModal = true;
    }

    public function closeCashTransferModal()
    {
        $this->showCashTransferModal = false;
    }

    public function saveCashTransfer()
    {
        $this->validate([
            'transferAmount' => 'required|numeric|min:0.5',
            'transferNotes' => 'nullable|string',
        ], [
            'transferAmount.required' => 'يرجى إدخال المبلغ المسلم للمدير',
            'transferAmount.numeric' => 'المبلغ يجب أن يكون رقمًا',
            'transferAmount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
        ]);

        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$activeShift) {
            session()->flash('error', 'لا يوجد شيفت مفتوح لهذا المستخدم.');

            return;
        }
        $managerId = User::where('role', 'admin')->value('id');

        \App\Models\CashTransfer::create([
            'from_shift_id' => $activeShift->id,
            'to_shift_id' => null,
            'branch_id' => $activeShift->branch_id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $managerId,
            'type' => 'to_manager',
            'amount' => $this->transferAmount,
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'notes' => $this->transferNotes,
        ]);

        $this->showCashTransferModal = false;

        session()->flash('success', 'تم تسجيل تسليم المبلغ للمدير بنجاح.');
    }

    #[Layout('layouts.app')]
    #[Title('البيع السريع (POS)')]
    public function render()
    {
        $storeOwnerId = StoreService::getStoreOwnerId();

        if ($this->requiresShiftStart) {
            return view('livewire.pos-page', [
                'products' => collect(),
                'categories' => collect(),
                'cartProductIds' => [],
            ]);
        }

        $categories = \App\Models\Category::where('user_id', $storeOwnerId)
            ->select('id', 'name')
            ->get();

        $this->deliveryMen = DeliveryMan::where('is_active', 1)
          ->get();

        $term = trim($this->search);

        $productsQuery = Product::where('user_id', $storeOwnerId)
            ->select(
                'id',
                'name',
                'barcode',
                'selling_price',
                'Purchase_price',
                'price',
                'cover',
                'category_id',
                'created_at'
            );

        if ($term !== '') {
            $productsQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', '%'.$term.'%')
                    ->orWhere('barcode', $term)
                    ->orWhereHas('sizes', function ($sizeQuery) use ($term) {
                        $sizeQuery->where('barcode', $term);
                    });
            });
        }

        if ($this->activeCategoryId) {
            $productsQuery->where('category_id', $this->activeCategoryId);
        }

        $products = $productsQuery
            ->with([
                'sizes:id,product_id,size,barcode,price,Purchase_price,selling_price',
            ])
            ->latest('id')
            ->take(80)
            ->get();

        return view('livewire.pos-page', [
            'products' => $products,
            'categories' => $categories,
            'cartProductIds' => collect($this->cart)->pluck('id')->toArray(),
            'deliveryMen' => $this->deliveryMen,
        ]);
    }

    // Open Orders Interface
    public $showOpenOrdersModal = false;
    public $openOrders = [];
    public $selectedOpenOrderId;

    public function loadOpenOrders()
    {
        $storeId = StoreService::getStoreOwnerId();
        $this->openOrders = Order::with('table', 'customer')
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
        $order = Order::find($orderId);
        if ($order) {
            $this->paidAmount = $order->total_price;
            $this->total = $order->total_price;
        }
    }

    public function payOpenOrder()
    {
        $order = Order::find($this->selectedOpenOrderId);

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
            $this->clearCart();
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

        $price = $this->getPosSellingPrice($product);
        $purchasePrice = (float) ($product->Purchase_price ?? 0);

        $name = $product->name;
        $effectiveSizeId = null;
        $sizeName = null;

        if ($this->modalSelectedSizeId) {
            $size = $product->sizes->find($this->modalSelectedSizeId);

            if ($size) {
                $price = $this->getPosSellingPrice($size);
                $purchasePrice = (float) ($size->Purchase_price ?? $product->Purchase_price ?? 0);

                $name = $product->name;
                $sizeName = $size->size;
                $effectiveSizeId = $size->id;
            }
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

                // سعر البيع المستخدم في POS
                'price' => $price,
                'selling_price' => $price,

                // سعر الشراء / التكلفة
                'purchase_price' => $purchasePrice,

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

        $price = $this->getPosSellingPrice($product);
        $purchasePrice = (float) ($product->Purchase_price ?? 0);

        $name = $product->name;
        $effectiveSizeId = null;
        $sizeName = null;

        if ($sizeId) {
            $size = $product->sizes->find($sizeId);

            if ($size) {
                $price = $this->getPosSellingPrice($size);
                $purchasePrice = (float) ($size->Purchase_price ?? $product->Purchase_price ?? 0);

                $name = $product->name;
                $sizeName = $size->size;
                $effectiveSizeId = $size->id;
            }
        } elseif ($price <= 0 && $product->sizes->isNotEmpty()) {
            $size = $product->sizes->first();

            $price = $this->getPosSellingPrice($size);
            $purchasePrice = (float) ($size->Purchase_price ?? $product->Purchase_price ?? 0);

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

            // سعر البيع
            'price' => $price,
            'selling_price' => $price,

            // سعر الشراء
            'purchase_price' => $purchasePrice,

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

    private function loadBusinessType($storeOwnerId)
    {
        $this->businessTypeSlug = 'rest';

        $user = User::find($storeOwnerId);

        $businessTypeId = $user?->business_type_id ?? null;

        if ($businessTypeId) {
            $slug = DB::table('business_types')
                ->where('id', $businessTypeId)
                ->where('is_active', 1)
                ->value('slug');

            $this->businessTypeSlug = $slug ?: 'rest';
        }

        if ($this->businessTypeSlug === 'acc') {
            // محل
            $this->availableOrderTypes = [
                'takeaway',
                'delivery',
            ];

            return;
        }

        // مطعم
        $this->availableOrderTypes = [
            'takeaway',
            'table',
            'free_seating',
            'delivery',
        ];
    }

    private function normalizeOrderType()
    {
        if (!in_array($this->orderType, $this->availableOrderTypes, true)) {
            $this->orderType = 'takeaway';
            $this->selectedTableId = null;
        }
    }

    public function setOrderType($type)
    {
        if (!in_array($type, $this->availableOrderTypes, true)) {
            return;
        }

        $this->orderType = $type;

        if ($type !== 'table') {
            $this->selectedTableId = null;
        }

        if ($type !== 'delivery') {
            $this->deliveryFee = 0;
            $this->selectedDeliveryManId = null;
        }

        $this->calculateTotal();
    }

    public function updatedOrderType()
    {
        $this->normalizeOrderType();
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
        session()->flash('error', 'يرجى إدخال بيانات العميل!');
        return;
    }

    if ($this->orderType === 'delivery' && !$this->selectedDeliveryManId) {
        session()->flash('error', 'يرجى اختيار المندوب!');
        return;
    }

    $activeShift = Shift::where('user_id', auth()->id())
        ->where('status', 'active')
        ->latest()
        ->first();

    if (!$activeShift) {
        session()->flash('error', 'لا يوجد شيفت مفتوح.');
        return;
    }

    // ======================
    // حساب الدفعة بشكل صحيح
    // ======================
    $paidAmount = (float) $this->paidAmount;
    $total = (float) $this->total;

    $isDraft = in_array($this->orderType, ['table', 'free_seating'])
        && $paidAmount == 0;

    // delivery = مدفوع كامل
    if ($this->orderType === 'delivery') {
        $paidAmount = $total;
        $this->changeAmount = 0;
    } else {
        $this->changeAmount = max(0, $paidAmount - $total);
    }

    if (!$isDraft && $paidAmount < $total) {
        session()->flash('error', 'المبلغ المدفوع أقل من الإجمالي!');
        return;
    }

    $savedOrderId = null;

    DB::transaction(function () use ($activeShift, $isDraft, &$savedOrderId, $paidAmount) {

        $userId = auth()->id();

        $storeOwnerId = auth()->user()->role === 'super_admin'
            ? $userId
            : (auth()->user()->created_by ?? $userId);

        $finalCustomerId = $this->selectedCustomerId;

        if (!$finalCustomerId && $this->customerPhone && $this->customerName) {
            $customer = Customer::create([
                'user_id' => $storeOwnerId,
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
            ]);

            $finalCustomerId = $customer->id;
        }

        $order = null;

        if ($this->orderType === 'table' && $this->selectedTableId) {
            $order = Order::where('table_id', $this->selectedTableId)
                ->where('status', 'pending')
                ->first();
        }

        $status = $isDraft ? 'pending' : 'served';

        if ($order) {
            $order->update([
                'shift_id' => $activeShift->id,
                'customer_id' => $finalCustomerId,
                'total_price' => $this->total,
                'status' => $status,
                'payment_method' => $this->paymentMethod,

                // ✅ هنا الإصلاح الأساسي
                'paid_amount' => $paidAmount,
                'change_amount' => $this->changeAmount,

                'delivery_fee' => $this->deliveryFee,
                'delivery_man_id' => $this->selectedDeliveryManId,
                'kitchen_note' => $this->kitchenNote,
            ]);
        } else {
            $order = Order::create([
                'user_id' => $storeOwnerId,
                'shift_id' => $activeShift->id,
                'customer_id' => $finalCustomerId,
                'status' => $status,
                'type' => $this->orderType,
                'table_id' => $this->orderType === 'table' ? $this->selectedTableId : null,
                'total_price' => $this->total,
                'payment_method' => $this->paymentMethod,

                // ✅ هنا الإصلاح الأساسي
                'paid_amount' => $paidAmount,
                'change_amount' => $this->changeAmount,

                'delivery_fee' => $this->deliveryFee,
                'delivery_man_id' => $this->selectedDeliveryManId,
                'kitchen_note' => $this->kitchenNote,
                'source' => 'pos',
            ]);
        }

        foreach ($this->cart as $item) {
            if (!isset($item['id'])) continue;

            DB::table('order_product_sizes')->insert([
                'order_id' => $order->id,
                'product_size_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $savedOrderId = $order->id;
        $this->lastOrderId = $order->id;
    });

    if ($savedOrderId && !$isDraft) {
        $this->dispatch('print-order', url: route('pos.orders.print-two', $savedOrderId));

        $this->clearCart();

        session()->flash('success', 'تمت العملية بنجاح');
        return;
    }

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

        $sourceOrder = Order::find($this->mergeSourceOrderId);
        if (!$sourceOrder || $sourceOrder->type !== 'table') {
            session()->flash('merge_error', 'طلب المصدر غير صالح للدمج.');

            return;
        }

        if ($sourceOrder->table_id == $this->mergeTargetTableId) {
            session()->flash('merge_error', 'لا يمكن دمج الطاولة مع نفسها.');

            return;
        }

        /** @var User $user */
        $user = auth()->user();
        $storeOwnerId = $user->role === 'super_admin' ? $user->id : ($user->getAttribute('created_by') ?? $user->id);

        // Find Target Order (if exists and pending)
        $targetOrder = Order::where('table_id', $this->mergeTargetTableId)
            ->where('status', 'pending')
            ->where('user_id', $storeOwnerId)
            ->first();

        DB::transaction(function () use ($sourceOrder, $targetOrder) {
            if ($targetOrder) {
                // Target has an active order, transfer items and update totals
                foreach ($sourceOrder->items as $item) {
                    DB::table('order_product_sizes')->insert([
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
        $this->kitchenNote = '';
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
        $order = Order::with(['items.product', 'items.inventory', 'customer'])
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
                    'selling_price' => floatval($item->pivot->price),
                    'purchase_price' => floatval($item->pivot->purchase_price ?? 0),
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

    private function getPosSellingPrice($model): float
    {
        return (float) (($model->selling_price ?? 0) > 0
            ? $model->selling_price
            : ($model->price ?? 0));
    }

    public function scanBarcode()
    {
        $code = trim($this->search);

        if ($code === '') {
            return;
        }

        $storeOwnerId = StoreService::getStoreOwnerId();

        $product = Product::where('user_id', $storeOwnerId)
            ->where('barcode', $code)
            ->first();

        if ($product) {
            $this->addToCart($product->id);
            $this->search = '';

            return;
        }

        $size = ProductSize::where('barcode', $code)
            ->whereHas('product', function ($q) use ($storeOwnerId) {
                $q->where('user_id', $storeOwnerId);
            })
            ->first();

        if ($size) {
            $this->addToCart($size->product_id, $size->id);
            $this->search = '';

            return;
        }

        session()->flash('error', 'لم يتم العثور على منتج بهذا الباركود.');
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->total = 0;
        $this->paidAmount = 0;
        $this->changeAmount = 0;

        $this->customerPhone = '';
        $this->customerName = '';
        $this->selectedCustomerId = null;

        $this->selectedTableId = null;
        $this->selectedDeliveryManId = null;
        $this->kitchenNote = '';

        // 🔥 مهم جدًا
        session()->forget('cart');
    }

    // فنكشن لائقاف المودال
    public function addDeliveryMan()
    {
        $this->validate([
            'newDeliveryManName' => 'required|string|max:255',
            'newDeliveryManPhone' => 'nullable|string|max:20',
            'newDeliveryManCommission' => 'nullable|numeric|min:0|max:100',
        ]);

        $storeOwnerId = StoreService::getStoreOwnerId();

        $man = DeliveryMan::create([
            'user_id' => $storeOwnerId,
            'name' => $this->newDeliveryManName,
            'phone' => $this->newDeliveryManPhone,
            'commission_percent' => $this->newDeliveryManCommission ?? 0,
            'is_active' => 1,
        ]);

        // إضافة مباشرة للقائمة الحالية
        $this->deliveryMen->push($man);

        // تحديد المندوب الجديد تلقائيًا
        $this->selectedDeliveryManId = $man->id;

        // مسح الفورم وإغلاق المودال
        $this->newDeliveryManName = '';
        $this->newDeliveryManPhone = '';
        $this->newDeliveryManCommission = 0;
        $this->showAddDeliveryManModal = false;

        session()->flash('success', 'تم إضافة مندوب جديد بنجاح');
    }
}
