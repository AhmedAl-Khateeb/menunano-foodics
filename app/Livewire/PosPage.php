<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Session;
use App\Models\Product;

#[Layout('layouts.app')]
class PosPage extends Component
{
    #[Url(as: 'q', history: true)]
    public $search = '';

    #[Url(as: 'cat', history: true)]
    public $activeCategoryId = null; // Filter by category
    
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
    public $selectedProductId = null; // Changed from Model to ID
    public $modalQuantity = 1;
    public $modalSelectedSizeId = null;

    // Customer Properties
    public $customerPhone = '';
    public $customerName = '';
    public $selectedCustomerId = null;

    // Computed Property to fetch product safely
    public function getSelectedProductForSizeProperty()
    {
        if (!$this->selectedProductId) return null;
        return \App\Models\Product::with('sizes')->find($this->selectedProductId);
    }

    public function updatedCustomerPhone()
    {
        $this->selectedCustomerId = null;
        // Search by phone
        if (strlen($this->customerPhone) > 3) {
            $storeOwnerId = \App\Services\StoreService::getStoreOwnerId();
            $customer = \App\Models\Customer::where('user_id', $storeOwnerId)
                        ->where('phone', 'like', '%' . $this->customerPhone . '%')
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
        $storeId = \App\Services\StoreService::getStoreOwnerId();
        $this->paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
                                ->where('created_by', $storeId)
                                ->get();
        
        // Default payment method
        if($this->paymentMethods->isNotEmpty()) {
            $this->paymentMethod = $this->paymentMethods->first()->id;
        }

        // Fix: Recalculate total if cart has items (persisted in session)
        if(!empty($this->cart)) {
            $this->calculateTotal();
        }
    }

    #[Layout('layouts.app')]
    #[Title('البيع السريع (POS)')]
    public function render()
    {
        $storeOwnerId = \App\Services\StoreService::getStoreOwnerId();
        
        // Fetch Categories
        $categories = \App\Models\Category::where('user_id', $storeOwnerId)->get();

        // Fetch Products
        $productsQuery = \App\Models\Product::where('user_id', $storeOwnerId)
                        ->where('name', 'like', '%'.$this->search.'%');
        
        if ($this->activeCategoryId) {
            $productsQuery->where('category_id', $this->activeCategoryId);
        }

        $products = $productsQuery->with('sizes')->latest()->get(); 

        return view('livewire.pos-page', [
            'products' => $products,
            'categories' => $categories,
            'cartProductIds' => collect($this->cart)->pluck('id')->toArray()
        ]);
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
        
        if($product) {
             $this->modalQuantity = 1;
             if($product->sizes->isNotEmpty()){
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
        $this->modalQuantity++;
    }

    public function decrementModalQuantity()
    {
        if($this->modalQuantity > 1) {
            $this->modalQuantity--;
        }
    }

    public function confirmModalAddToCart()
    {
        $product = $this->selectedProductForSize;
        if(!$product) return;

        if($product->sizes->isNotEmpty() && !$this->modalSelectedSizeId) {
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

        $cartItemId = $product->id . ($effectiveSizeId ? '-' . $effectiveSizeId : '');

        $found = false;
        foreach($this->cart as $index => $item) {
            if(isset($item['cart_item_id']) && $item['cart_item_id'] === $cartItemId) {
                $this->cart[$index]['quantity'] += $this->modalQuantity;
                $found = true;
                break;
            }
        }

        if(!$found) {
            $this->cart[] = [
                'cart_item_id' => $cartItemId,
                'id' => $product->id,
                'size_id' => $effectiveSizeId,
                'name' => $name,
                'size_name' => $sizeName,
                'price' => floatval($price),
                'quantity' => $this->modalQuantity,
                'cover' => $product->cover
            ];
        }

        $this->calculateTotal();
        $this->closeSizeModal();
    }

    public function addToCart($productId, $sizeId = null)
    {
        $product = \App\Models\Product::with('sizes')->find($productId);
        if(!$product) return;

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
        } 
        elseif ($price <= 0 && $product->sizes->isNotEmpty()) {
             $size = $product->sizes->first();
             $price = $size->price;
             $name = $product->name;
             $sizeName = $size->size;
             $effectiveSizeId = $size->id;
        }

        $cartItemId = $product->id . ($effectiveSizeId ? '-' . $effectiveSizeId : '');

        foreach($this->cart as $index => $item) {
            if(isset($item['cart_item_id']) && $item['cart_item_id'] === $cartItemId) {
                $this->cart[$index]['quantity']++;
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
            'cover' => $product->cover
        ];
        $this->calculateTotal();
        $this->closeSizeModal();
    }

    public function increment($index)
    {
        $this->cart[$index]['quantity']++;
        $this->calculateTotal();
    }

    public function decrement($index)
    {
        if($this->cart[$index]['quantity'] > 1) {
            $this->cart[$index]['quantity']--;
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
        foreach($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }
        $this->updatedPaidAmount();
    }

    public $showSuccessModal = false;
    public $lastOrderId = null;

    // ... (existing methods)

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'السلة فارغة!');
            return;
        }

        if ($this->paymentMethod === 'cash' && $this->paidAmount < $this->total) {
            session()->flash('error', 'المبلغ المدفوع أقل من الإجمالي!');
            return;
        }

        // DB Transaction to ensure data integrity
        \Illuminate\Support\Facades\DB::transaction(function () {
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

            // Create Order
            $order = \App\Models\Order::create([
                'user_id' => $storeOwnerId,
                'customer_id' => $finalCustomerId, // Linked Customer
                'status' => 'served', // Direct sale
                'total_price' => $this->total,
                'payment_method' => $this->paymentMethod,
                'source' => 'pos', 
                'paid_amount' => $this->paidAmount,
                'change_amount' => $this->changeAmount,
            ]);

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
                            'price' => $item['price']
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

        // Don't reset cart here immediately, wait for user confirmation or new order
        // But to prevent double submit we might want to clear or lock. 
        // Requirement says: "When he creates the order... asks him if he wants to return to products"
        // So successful state should be shown.
        $this->showSuccessModal = true;
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
        $this->activeTab = 'products'; // Return to products
    }
}
