@php
    $migrationRun = \Illuminate\Support\Facades\Schema::hasColumn('orders', 'source');
@endphp

<div class="min-h-screen w-full flex flex-col bg-gray-50 bg-pattern" dir="rtl" x-data>
    @if(!$migrationRun)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p class="font-bold"><i class="fas fa-exclamation-triangle"></i> تنبيه</p>
            <p>لم يتم تشغيل الترحيل (Migration). يرجى مراجعة المبرمج.</p>
        </div>
    @endif

    <!-- Main Tabs Navigation (Mobile Only) -->
    <div class="flex mb-3 bg-white rounded-xl shadow-sm p-1 max-w-4xl mx-auto md:hidden sticky top-2 z-20">
        <button class="flex-1 py-3 rounded-lg font-bold text-base transition-all {{ $activeTab === 'products' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}"
                wire:click="setTab('products')">
            <i class="fas fa-th-large mr-2"></i> المنتجات
        </button>
        <button class="flex-1 py-3 rounded-lg font-bold text-base transition-all {{ $activeTab === 'cart' ? 'bg-green-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}"
                wire:click="setTab('cart')">
            <i class="fas fa-shopping-cart mr-2"></i> السلة
            @if(count($cart) > 0)
                <span class="bg-white/20 px-2 py-0.5 rounded-full text-xs mr-2">{{ count($cart) }}</span>
            @endif
        </button>
    </div>

    <!-- Content Area (Grid on Desktop) -->
    <div class="max-w-full mx-auto pb-24 md:pb-3 md:grid md:grid-cols-3 md:gap-3 px-2 md:px-3">
        
        <!-- PRODUCTS SECTION (Right) -->
        <div class="{{ $activeTab === 'products' ? 'flex' : 'hidden md:flex' }} md:col-span-2 flex-col gap-3 animate-fade-in pl-1">
            
            <!-- Header: Search & Categories -->
            <div class="bg-white p-3 rounded-xl shadow-sm flex flex-col gap-3 shrink-0 sticky top-[58px] z-10 border border-gray-100">
                <!-- Search -->
                <div class="relative w-full">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all font-sans text-gray-700 placeholder-gray-400 text-sm" 
                           placeholder="بحث عن منتج (الاسم / الباركود)...">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </div>
                </div>

                <!-- Categories -->
                <div x-data="{
                        scrollContent() {
                            const container = this.$refs.container;
                        },
                        scrollLeft() { 
                            this.$refs.container.scrollBy({ left: 200, behavior: 'smooth' });
                        },
                        scrollRight() { 
                            this.$refs.container.scrollBy({ left: -200, behavior: 'smooth' });
                        }
                     }" 
                     class="relative w-full group">
                    
                    <!-- Right Arrow (Desktop) -->
                    <button @click="scrollRight()" 
                            class="hidden lg:flex absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 backdrop-blur shadow-md border border-gray-100 w-7 h-7 rounded-full items-center justify-center text-gray-600 hover:text-blue-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>

                    <!-- Scroll Container -->
                    <div x-ref="container" 
                         class="w-full overflow-x-auto pb-1 scrollbar-none scroll-smooth flex gap-2 px-1 no-scrollbar">
                        <button class="shrink-0 px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 border {{ is_null($activeCategoryId) ? 'bg-gray-800 text-white border-gray-800 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}" 
                                wire:click="setCategory(null)">
                            <i class="fas fa-th-large ml-1"></i> الكل
                        </button>
                        @foreach($categories as $cat)
                            <button class="shrink-0 px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 border {{ $activeCategoryId === $cat->id ? 'bg-blue-600 text-white border-blue-600 shadow-md scale-105' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}" 
                                    wire:click="setCategory({{ $cat->id }})">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Left Arrow (Desktop) -->
                    <button @click="scrollLeft()" 
                            class="hidden lg:flex absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 backdrop-blur shadow-md border border-gray-100 w-7 h-7 rounded-full items-center justify-center text-gray-600 hover:text-blue-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="bg-white rounded-xl shadow-sm p-3 min-h-[500px] flex-1">
                @if($products->isEmpty())
                     <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                        <i class="fas fa-box-open text-5xl mb-3 opacity-50"></i>
                        <h4 class="text-lg font-bold">لا توجد منتجات</h4>
                     </div>
                @else
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-2">
                        @foreach($products as $product)
                            @php
                                $isInCart = in_array($product->id, $cartProductIds);
                            @endphp
                            <div wire:key="product-{{ $product->id }}" 
                                 class="group relative bg-white border {{ $isInCart ? 'border-green-500 ring-2 ring-green-100 shadow-md' : 'border-gray-100 hover:shadow-lg' }} rounded-lg overflow-hidden transition-all duration-300 cursor-pointer h-full flex flex-col" 
                                 wire:click="openSizeModal({{ $product->id }})">
                                <!-- Image with Overlay -->
                                <div class="relative aspect-square overflow-hidden bg-gray-100 shrink-0">
                                     <img src="{{ $product->cover ? asset('storage/' . $product->cover) : asset('dist/img/prod-1.jpg') }}" 
                                          class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                                          alt="{{ $product->name }}">
                                    <!-- Add Overlay -->
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                                    @if($isInCart)
                                        <div class="absolute top-1.5 right-1.5 bg-green-500 text-white w-5 h-5 rounded-full flex items-center justify-center shadow-md animate-bounce">
                                            <i class="fas fa-check text-[10px]"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-2 text-center flex-1 flex flex-col justify-between">
                                    <div>
                                        <h6 class="font-bold text-gray-800 text-xs mb-1 line-clamp-2 leading-tight tracking-tight">{{ $product->name }}</h6>
                                        <div class="inline-block bg-blue-50 text-blue-700 text-[10px] font-bold px-1.5 py-0.5 rounded">
                                            @if($product->price > 0)
                                                {{ number_format($product->price, 2) }}
                                            @elseif($product->sizes->isNotEmpty())
                                                {{ number_format($product->sizes->first()->price, 2) }}
                                            @else
                                                0.00
                                            @endif
                                            ج.م
                                        </div>
                                    </div>
                                    
                                    @if($product->sizes->isNotEmpty())
                                        <div class="mt-1 text-center">
                                            <span class="text-[9px] bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded-full border border-indigo-100 font-bold inline-block">
                                                <i class="fas fa-layer-group text-[7px] mr-1"></i> {{ $product->sizes->count() }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- CART/INVOICE SECTION (Left) -->
        <div class="{{ $activeTab === 'cart' ? 'flex' : 'hidden md:flex' }} md:col-span-1 flex-col animate-fade-in md:sticky md:top-[58px] md:h-[calc(100vh-70px)]">
             <div class="bg-white rounded-xl shadow-lg flex flex-col border border-gray-100 h-full overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300">
                <!-- Header -->
                <div class="bg-gray-900 p-4 text-white flex justify-between items-center shadow-md shrink-0">
                    <h5 class="font-bold text-xl flex items-center gap-2">
                        <i class="fas fa-file-invoice-dollar text-2xl text-yellow-500"></i> الفاتورة
                    </h5>
                    @if(!empty($cart))
                        <button wire:click="openResetModal" class="text-red-400 hover:text-red-200 transition-colors" title="تفريغ الفاتورة">
                            <i class="fas fa-trash-alt text-lg"></i>
                        </button>
                    @endif
                </div>

                <!-- Cart Items List -->
                <div class="p-4">
                    @if(empty($cart))
                        <div class="flex flex-col items-center justify-center h-full text-gray-400 opacity-60">
                            <i class="fas fa-cart-arrow-down text-6xl mb-4"></i>
                             <h3 class="font-bold text-xl">السلة فارغة</h3>
                             <p class="mt-2 text-gray-500">قم بالذهاب لتبويب المنتجات للإضافة</p>
                             <button class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition" wire:click="setTab('products')">
                                الذهاب للمنتجات
                             </button>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($cart as $index => $item)
                                <div wire:key="cart-item-{{ $item['cart_item_id'] }}" class="bg-white rounded-lg p-2 flex gap-2 border border-gray-100 hover:border-blue-200 transition-all shadow-sm group items-start">
                                    <!-- Image & Index -->
                                    <div class="relative shrink-0">
                                         <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-gray-800 text-white flex items-center justify-center text-[10px] font-bold shadow-sm z-10">{{ $index + 1 }}</span>
                                         <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden border border-gray-200">
                                            <img src="{{ isset($item['cover']) && $item['cover'] ? asset('storage/' . $item['cover']) : asset('dist/img/prod-1.jpg') }}" class="w-full h-full object-cover">
                                         </div>
                                    </div>

                                    <!-- Details & Controls -->
                                    <div class="flex-1 min-w-0 flex flex-col justify-between self-stretch">
                                        <!-- Top Row: Name & Remove -->
                                        <div class="flex justify-between items-start gap-1">
                                            <h6 class="font-bold text-gray-800 text-sm leading-tight line-clamp-2" title="{{ $item['name'] }}">{{ $item['name'] }}</h6>
                                            <button wire:click="removeFromCart({{ $index }})" class="text-gray-300 hover:text-red-500 transition-colors bg-transparent hover:bg-red-50 rounded p-0.5 shrink-0">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <!-- Bottom Row: Price, Extras, Quantity, Total -->
                                        <div class="flex items-end justify-between mt-1">
                                            <!-- Price & Size -->
                                            <div class="flex flex-col">
                                                 @if(isset($item['size_name']) && $item['size_name'])
                                                     <span class="text-[9px] bg-indigo-50 text-indigo-700 px-1 rounded border border-indigo-100 font-bold self-start mb-0.5">
                                                         {{ $item['size_name'] }}
                                                     </span>
                                                 @endif
                                                 <div class="text-[10px] text-gray-500 font-bold">
                                                     {{ number_format($item['price'], 2) }} ×
                                                 </div>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="flex items-center bg-gray-50 rounded border border-gray-200 h-6 mx-1">
                                                <button wire:click="increment({{ $index }})" class="w-6 h-full text-green-600 hover:bg-green-100 rounded-r transition-colors flex items-center justify-center"><i class="fas fa-plus text-[9px]"></i></button>
                                                <div class="w-8 h-full flex items-center justify-center font-bold text-xs bg-white border-x border-gray-200">{{ $item['quantity'] }}</div>
                                                <button wire:click="decrement({{ $index }})" class="w-6 h-full text-red-500 hover:bg-red-100 rounded-l transition-colors flex items-center justify-center"><i class="fas fa-minus text-[9px]"></i></button>
                                            </div>
                                            
                                            <!-- Row Total -->
                                            <div class="font-black text-gray-800 text-sm">
                                                {{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Footer Summary -->
                @if(!empty($cart))
                <div class="bg-white border-t border-gray-100 p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] shrink-0 z-10 w-full max-w-4xl mx-auto">
                    <!-- Total Row -->
                    <div class="flex justify-between items-end mb-4 bg-gray-50 p-3 rounded-xl border border-gray-200">
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-xs font-bold mb-1">صافي الفاتورة</span>
                            <span class="text-3xl font-black text-gray-900 leading-none">{{ number_format($total, 2) }} <span class="text-sm font-normal text-gray-400">ج.م</span></span>
                        </div>
                        <div class="text-left">
                            <span class="text-xs text-gray-400 font-bold block mb-1">عدد العناصر</span>
                            <span class="bg-white px-3 py-1 rounded-md border border-gray-200 font-bold text-gray-700 shadow-sm">{{ count($cart) }}</span>
                        </div>
                    </div>

                    <!-- Customer Info (Search by Phone / Link) -->
                    <div class="mb-4 bg-gray-50 p-3 rounded-xl border border-gray-200">
                        <label class="text-xs font-bold text-gray-500 mb-2 block px-1">ربط عميل (بحث / إضافة)</label>
                        <div class="grid grid-cols-2 gap-3" x-data="{ showNameInput: false }">
                            <!-- Phone Input with Debounce Search -->
                            <div class="col-span-1">
                                <label class="text-[10px] text-gray-400 font-bold mb-1 block">رقم الهاتف</label>
                                <div class="relative">
                                    <input type="text" wire:model.live.debounce.500ms="customerPhone" 
                                           class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm font-bold focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                                           placeholder="01xxxxxxxxx"
                                           x-on:input="showNameInput = false"> <!-- Reset input view on phone change -->
                                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                                </div>
                            </div>
                            
                            <!-- Name Section -->
                            <div class="col-span-1 flex items-end">
                                @if($selectedCustomerId)
                                    <!-- Found Customer -->
                                    <div class="w-full">
                                        <label class="text-[10px] text-green-600 font-bold mb-1 block">العميل المسجل</label>
                                        <div class="w-full bg-green-50 border border-green-200 rounded-lg px-3 py-2 text-sm font-bold text-green-800 flex items-center justify-between">
                                            <span>{{ $customerName }}</span>
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                @elseif(strlen($customerPhone) > 3)
                                    <!-- New Customer Option -->
                                    <div class="w-full" x-show="!showNameInput && '$wire.customerName' == ''">
                                         <button type="button" @click="showNameInput = true" 
                                                 class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 rounded-lg px-3 py-2 text-sm font-bold transition-all flex items-center justify-center gap-2 h-[38px]">
                                            <i class="fas fa-plus"></i> إضافة عميل جديد
                                         </button>
                                    </div>
                                    <div class="w-full" x-show="showNameInput || '$wire.customerName' != ''">
                                        <label class="text-[10px] text-blue-500 font-bold mb-1 block">اسم العميل الجديد</label>
                                        <input type="text" wire:model="customerName" 
                                               class="w-full bg-white border border-blue-300 rounded-lg px-3 py-2 text-sm font-bold focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                                               placeholder="الاسم مطلوب"
                                               x-init="$el.focus()">
                                    </div>
                                @else
                                    <!-- Placeholder -->
                                    <div class="w-full h-[38px] bg-gray-100 border border-dashed border-gray-300 rounded-lg flex items-center justify-center text-xs text-gray-400">
                                        أدخل الرقم أولاً
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment & Action -->
                    <div class="flex flex-col gap-3">
                         <!-- Payment Methods Selector -->
                         <div>
                            <label class="text-xs font-bold text-gray-400 mb-2 block px-1">طريقة الدفع</label>
                            <div class="flex flex-wrap gap-2">
                                <!-- Cash Option -->
                                <button class="flex-1 py-2 rounded-xl font-bold text-sm transition-all flex flex-col items-center justify-center gap-1 border h-16 {{ $paymentMethod === 'cash' ? 'bg-green-600 text-white border-green-600 shadow-lg ring-2 ring-green-100' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}"
                                        wire:click="$set('paymentMethod', 'cash')">
                                    <div class="flex items-center gap-2"><i class="fas fa-money-bill-wave"></i> نقدي</div>
                                    <span class="text-[10px] {{ $paymentMethod === 'cash' ? 'bg-white/20' : 'bg-gray-100 text-gray-500' }} px-2 rounded-full">المطلوب: {{ number_format($total, 2) }}</span>
                                </button>
                                
                                <!-- Dynamic Options -->
                                @foreach($paymentMethods as $method)
                                    <button class="flex-1 py-2 rounded-xl font-bold text-sm transition-all flex flex-col items-center justify-center gap-0.5 border h-16 {{ $paymentMethod == $method->id ? 'bg-blue-600 text-white border-blue-600 shadow-lg ring-2 ring-blue-100' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}"
                                            wire:click="$set('paymentMethod', '{{ $method->id }}')">
                                        <div class="flex items-center gap-2"><i class="fas fa-wallet"></i> {{ $method->name }}</div>
                                        @if($method->phone)
                                            <span class="text-[10px] opacity-80 font-mono tracking-wider">{{ $method->phone }}</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                         </div>

                         <!-- Cash Calculations -->
                         <div class="grid grid-cols-2 gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100" x-show="$wire.paymentMethod === 'cash'" x-transition>
                            <div class="col-span-2 flex justify-between items-center mb-1 text-xs font-bold text-gray-500 px-1">
                                <span>حاسبة النقدية</span>
                                <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded">الإجمالي: {{ number_format($total, 2) }}</span>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 mb-1 block">المبلغ الذي دخل الدرج</label>
                                <div class="relative">
                                    <input type="number" step="0.5" wire:model.live.debounce.300ms="paidAmount" 
                                           class="w-full bg-white border border-gray-300 rounded-xl pl-2 pr-4 py-2.5 font-bold text-lg text-gray-800 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm" 
                                           placeholder="0.00">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500 mb-1 block">المتبقي للعميل</label>
                                <div class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 font-bold text-lg flex items-center justify-between {{ $changeAmount < 0 ? 'text-red-500 bg-red-50 border-red-100' : 'text-green-600' }}">
                                    <span>{{ number_format(abs($changeAmount), 2) }}</span>
                                    <span class="text-xs text-gray-400 font-normal">{{ $changeAmount < 0 ? 'عليك' : 'إرجاع' }}</span>
                                </div>
                            </div>
                         </div>


                         <button class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl shadow-lg transition-transform transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-lg mt-2"
                                 wire:click="checkout"
                                 wire:loading.attr="disabled"
                                 {{ ($paymentMethod === 'cash' && $paidAmount < $total) ? 'disabled' : '' }}>
                             <span wire:loading.remove><i class="fas fa-check-circle mr-2"></i> إتمام عملية البيع</span>
                             <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i> جاري المعالجة...</span>
                         </button>
                    </div>
                </div>
                @endif
             </div>
        </div>

    </div>
    
    <!-- Advanced Add to Cart Modal -->
    @if($showSizeModal && $this->selectedProductForSize)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm transition-opacity animate-fade-in text-right" dir="rtl">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg transform transition-all scale-100 max-h-[90vh] overflow-y-auto custom-scrollbar relative">
            
            <!-- Header (Scrolls with content) -->
            <div class="relative bg-gray-100 h-48 w-full">
                <img src="{{ $this->selectedProductForSize->cover ? asset('storage/' . $this->selectedProductForSize->cover) : asset('dist/img/prod-1.jpg') }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <button wire:click="closeSizeModal" class="absolute top-4 left-4 w-10 h-10 bg-white/20 backdrop-blur text-white hover:bg-white hover:text-red-500 rounded-full flex items-center justify-center transition-all shadow-lg z-20">
                    <i class="fas fa-times text-lg"></i>
                </button>
                <div class="absolute bottom-4 right-4 text-white z-10 w-full px-4">
                    <h3 class="font-bold text-2xl shadow-sm truncate">{{ $this->selectedProductForSize->name }}</h3>
                </div>
            </div>

            <!-- Body Controls -->
            <div class="p-6 pb-0">
                
                <!-- Size Selector (Slider) -->
                @if($this->selectedProductForSize->sizes->isNotEmpty())
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-3 text-sm flex items-center">
                            <i class="fas fa-ruler-combined text-blue-500 ml-2"></i> اختر الحجم
                        </label>
                        <div class="flex overflow-x-auto gap-3 pb-4 scrollbar-thin scrollbar-thumb-gray-300">
                            @foreach($this->selectedProductForSize->sizes as $size)
                                <button class="shrink-0 relative px-6 py-3 rounded-2xl border-2 transition-all flex flex-col items-center min-w-[100px] {{ $modalSelectedSizeId === $size->id ? 'border-blue-500 bg-blue-50 text-blue-700 shadow-md ring-2 ring-blue-200' : 'border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 hover:bg-gray-100' }}"
                                        wire:click="selectSize({{ $size->id }})">
                                    <span class="font-bold text-lg mb-1">{{ $size->size }}</span>
                                    <span class="text-xs font-bold bg-white px-2 py-0.5 rounded border {{ $modalSelectedSizeId === $size->id ? 'border-blue-200 text-blue-600' : 'border-gray-200 text-gray-500' }}">
                                        {{ number_format($size->price, 2) }}
                                    </span>
                                    @if($modalSelectedSizeId === $size->id)
                                        <div class="absolute -top-2 -left-2 bg-blue-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs shadow-sm">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quantity Selector -->
                <div class="mb-2">
                    <label class="block text-gray-500 font-bold mb-3 text-sm flex items-center">
                        <i class="fas fa-cubes text-green-600 ml-2"></i> تحديد الكمية
                    </label>
                    <div class="flex items-center justify-center bg-gray-50 rounded-2xl p-2 border border-gray-100 w-full max-w-[200px] mx-auto">
                        <button wire:click="decrementModalQuantity" class="w-12 h-12 rounded-xl bg-white text-red-500 shadow-sm hover:bg-red-50 hover:scale-105 transition-all text-xl font-bold flex items-center justify-center">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="flex-1 text-center font-black text-3xl text-gray-800">
                            {{ $modalQuantity }}
                        </div>
                        <button wire:click="incrementModalQuantity" class="w-12 h-12 rounded-xl bg-green-500 text-white shadow-green-200 shadow-lg hover:bg-green-600 hover:scale-105 transition-all text-xl font-bold flex items-center justify-center">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Footer (Total & Action) - Simple Block -->
            <div class="p-6 pt-4">
                @php
                    $selectedSize = $this->selectedProductForSize->sizes->find($modalSelectedSizeId);
                    $unitPrice = $selectedSize ? $selectedSize->price : ($this->selectedProductForSize->sizes->isEmpty() ? $this->selectedProductForSize->price : 0);
                    $totalPrice = $unitPrice * $modalQuantity;
                @endphp
                
                <div class="flex items-center justify-between mb-4 px-2 border-t border-dashed border-gray-200 pt-4">
                    <span class="text-gray-500 font-bold">الإجمالي المبدئي</span>
                    <span class="text-2xl font-black text-gray-900">{{ number_format($totalPrice, 2) }} <span class="text-sm font-normal text-gray-400">ج.م</span></span>
                </div>

                <div class="flex gap-3">
                    <button class="flex-1 py-4 text-xl font-bold rounded-2xl text-white shadow-xl transition-all transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3
                                   {{ $totalPrice > 0 ? 'bg-gradient-to-l from-blue-600 to-indigo-600 shadow-indigo-200 hover:shadow-indigo-300' : 'bg-gray-400 cursor-not-allowed' }}"
                            wire:click="confirmModalAddToCart"
                            {{ $modalSelectedSizeId || $this->selectedProductForSize->sizes->isEmpty() ? '' : 'disabled' }}>
                        <span>إضافة</span>
                        <i class="fas fa-cart-plus"></i>
                    </button>

                    <button class="flex-1 py-4 text-lg font-bold rounded-2xl bg-gray-50 text-gray-700 border border-gray-200 hover:bg-gray-100 transition-all active:scale-95"
                            wire:click="closeSizeModal">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Floating Reset Button Removed -->

    <!-- Reset Confirmation Modal -->
    @if($showResetModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity animate-fade-in" dir="rtl">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-100 flex flex-col">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">تأكيد تصفير السلة</h3>
                <p class="text-gray-500 mb-6">هل أنت متأكد من حذف جميع المنتجات من السلة؟ لا يمكن التراجع عن هذا الإجراء.</p>
                
                <div class="flex gap-3 justify-center">
                    <button wire:click="confirmReset" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-red-200">
                        <i class="fas fa-check mr-2"></i> نعم، حذف
                    </button>
                    <button wire:click="closeResetModal" 
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl transition-colors">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Success Modal -->
    <div x-data="{ show: @entangle('showSuccessModal') }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
         style="display: none;">
        
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center transform transition-all scale-100"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
            
            <h2 class="text-3xl font-black text-gray-900 mb-2">تم الطلب بنجاح!</h2>
            <p class="text-gray-500 mb-8">تم تسجيل الطلب وحفظ البيانات بنجاح.</p>
            
            <div class="flex flex-col gap-3">
                <button wire:click="startNewOrder" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition-transform transform active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> طلب جديد (العودة للمنتجات)
                </button>
                <!-- Print Receipt Button Placeholder -->
                 <button onclick="alert('Print functionality to be implemented')" 
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> طباعة الإيصال
                </button>
            </div>
        </div>
    </div>


    <!-- Reset Confirmation Modal -->
    @if($showResetModal)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeResetModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    تفريغ الفاتورة
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        هل أنت متأكد من رغبتك في حذف جميع العناصر من الفاتورة؟ لا يمكن التراجع عن هذا الإجراء.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" wire:click="confirmReset">
                            نعم، تفريغ
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" wire:click="closeResetModal">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>
