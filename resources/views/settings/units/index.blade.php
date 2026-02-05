@extends('layouts.app')

@section('main-content')
<div class="min-h-screen bg-gray-50/50" x-data="{ 
    activeTab: 'active',
    showAddModal: false,
    showEditModal: false, 
    showDeleteModal: false,
    editingUnit: null,
    
    // Form Data
    form: {
        id: null,
        name: '',
        symbol: '',
        type: 'count', // count, weight, volume
        allow_decimal: false,
        is_active: true,
        base_unit_id: '',
        conversion_rate: '',
        _method: 'POST'
    },
    
    resetForm() {
        this.form = {
            id: null,
            name: '',
            symbol: '',
            type: 'count',
            allow_decimal: false,
            is_active: true,
            base_unit_id: '',
            conversion_rate: '',
            _method: 'POST'
        };
        this.editingUnit = null;
    },
    
    openAddModal() {
        this.resetForm();
        
        // Auto-select Type based on URL Filter
        const urlParams = new URLSearchParams(window.location.search);
        const filterType = urlParams.get('type');
        
        if (filterType && ['count', 'weight', 'volume'].includes(filterType)) {
            this.form.type = filterType;
            // Apply Smart Default logic
            this.form.allow_decimal = (filterType === 'weight' || filterType === 'volume');
        }
        
        this.showAddModal = true;
    },
    
    openEditModal(unit) {
        this.resetForm();
        this.editingUnit = unit;
        this.form = {
            id: unit.id,
            name: unit.name,
            symbol: unit.symbol,
            type: unit.type,
            allow_decimal: !!unit.allow_decimal,
            is_active: !!unit.is_active,
            base_unit_id: unit.base_unit_id || '',
            conversion_rate: unit.conversion_rate || '',
            _method: 'PUT'
        };
        this.showEditModal = true;
    },
    
    openDeleteModal(unit) {
        this.editingUnit = unit;
        this.showDeleteModal = true;
    }
}">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm flex-shrink-0 border border-indigo-100/50">
                        <i class="fas fa-balance-scale text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight font-sans">
                            وحدات القياس
                        </h1>
                        <p class="text-sm font-medium text-gray-500">
                            إدارة وحدات القياس والتحويلات المخزنية
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openAddModal()" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 active:scale-95">
                        <i class="fas fa-plus"></i>
                        <span>إضافة وحدة</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Filter Tabs -->
        <div class="mb-8 flex overflow-x-auto pb-2 scrollbar-hide">
            <div class="flex p-1 bg-white rounded-xl border border-gray-100 shadow-sm">
                <!-- All Tab -->
                <a href="{{ route('units.index') }}" 
                   @class([
                       'px-6 py-2.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap border flex items-center gap-2',
                       'bg-indigo-600 shadow-lg shadow-indigo-200 ring-2 ring-indigo-600 ring-offset-2 border-transparent' => !request('type'),
                       'text-gray-500 hover:bg-gray-50 border-transparent hover:border-gray-200' => request('type')
                   ])>
                   <i class="fas fa-th-large {{ !request('type') ? '!text-white' : '' }}"></i> 
                   <span class="{{ !request('type') ? '!text-white' : '' }}">الكل</span>
                </a>
                
                <!-- Count Tab -->
                <a href="{{ route('units.index', ['type' => 'count']) }}" 
                   @class([
                       'px-6 py-2.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap border flex items-center gap-2',
                       'bg-blue-600 shadow-lg shadow-blue-200 ring-2 ring-blue-600 ring-offset-2 border-transparent' => request('type') == 'count',
                       'text-gray-500 hover:bg-gray-50 border-transparent hover:border-gray-200' => request('type') != 'count'
                   ])>
                   <i class="fas fa-hashtag {{ request('type') == 'count' ? '!text-white' : '' }}"></i> 
                   <span class="{{ request('type') == 'count' ? '!text-white' : '' }}">عدد</span>
                </a>
                
                <!-- Weight Tab -->
                <a href="{{ route('units.index', ['type' => 'weight']) }}" 
                   @class([
                       'px-6 py-2.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap border flex items-center gap-2',
                       'bg-orange-600 shadow-lg shadow-orange-200 ring-2 ring-orange-600 ring-offset-2 border-transparent' => request('type') == 'weight',
                       'text-gray-500 hover:bg-gray-50 border-transparent hover:border-gray-200' => request('type') != 'weight'
                   ])>
                   <i class="fas fa-weight-hanging {{ request('type') == 'weight' ? '!text-white' : '' }}"></i> 
                   <span class="{{ request('type') == 'weight' ? '!text-white' : '' }}">وزن</span>
                </a>
                
                <!-- Volume Tab -->
                <a href="{{ route('units.index', ['type' => 'volume']) }}" 
                   @class([
                       'px-6 py-2.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap border flex items-center gap-2',
                       'bg-teal-600 shadow-lg shadow-teal-200 ring-2 ring-teal-600 ring-offset-2 border-transparent' => request('type') == 'volume',
                       'text-gray-500 hover:bg-gray-50 border-transparent hover:border-gray-200' => request('type') != 'volume'
                   ])>
                   <i class="fas fa-flask {{ request('type') == 'volume' ? '!text-white' : '' }}"></i> 
                   <span class="{{ request('type') == 'volume' ? '!text-white' : '' }}">حجم</span>
                </a>
            </div>
        </div>

        <!-- Units Grid -->
        @if($units->isEmpty())
            <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-ruler-combined text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد وحدات قياس</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">قم بتعريف وحدات القياس الأساسية (مثل الكيلوجرام، اللتر، القطعة) لاستخدامها في المنتجات والمخزون.</p>
                <button @click="openAddModal()" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                    إضافة أول وحدة
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($units as $unit)
                    <div class="group bg-white rounded-3xl p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-indigo-100 transition-all duration-300 relative overflow-hidden flex flex-col h-full">
                        
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl 
                                    @if($unit->type == 'weight') bg-orange-50 text-orange-600
                                    @elseif($unit->type == 'volume') bg-teal-50 text-teal-600
                                    @else bg-blue-50 text-blue-600 @endif
                                    flex items-center justify-center text-lg shadow-sm">
                                    <i class="fas @if($unit->type == 'weight') fa-weight-hanging @elseif($unit->type == 'volume') fa-flask @else fa-hashtag @endif"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $unit->name }}</h3>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-md bg-gray-100 text-gray-500 font-mono mt-1 inline-block">{{ $unit->symbol }}</span>
                                </div>
                            </div>
                            
                            <!-- Actions Dropdown -->
                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity" @click.stop>
                                <button @click="openEditModal({{ $unit }})" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors" title="تعديل">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button @click="openDeleteModal({{ $unit }})" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="حذف">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="space-y-3 mb-4 flex-1">
                            <!-- Type Badge -->
                            <div>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                    @if($unit->type == 'weight') bg-orange-50 text-orange-600 border border-orange-100
                                    @elseif($unit->type == 'volume') bg-teal-50 text-teal-600 border border-teal-100
                                    @else bg-blue-50 text-blue-600 border border-blue-100 @endif">
                                    @if($unit->type == 'weight') وزن (Weight)
                                    @elseif($unit->type == 'volume') حجم (Volume)
                                    @else عدد (Count) @endif
                                </span>
                            </div>

                            <!-- Conversion Info -->
                            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100/50 mt-auto">
                                @if($unit->base_unit_id)
                                    <div class="flex items-center justify-between text-sm" dir="ltr">
                                        <div class="flex items-center gap-2 font-mono text-gray-700 bg-white px-2 py-1.5 rounded-lg border border-gray-100 shadow-sm w-full justify-center">
                                            <span class="font-bold text-indigo-600">1</span>
                                            <span class="text-xs text-gray-500">{{ $unit->symbol }}</span>
                                            <span class="text-gray-300">=</span>
                                            <span class="font-bold text-gray-900">{{ $unit->conversion_rate + 0 }}</span>
                                            <span class="text-xs text-gray-500">{{ $unit->baseUnit->symbol ?? '?' }}</span>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-center text-gray-400 mt-2">وحدة فرعية</p>
                                @else
                                    <div class="flex items-center justify-center gap-2 py-1.5 bg-green-50/50 rounded-lg border border-green-100/50 text-green-700">
                                        <i class="fas fa-crown text-xs"></i>
                                        <span class="text-xs font-bold">وحدة أساسية</span>
                                    </div>
                                    <p class="text-[10px] text-center text-gray-400 mt-2">المرجع للتحويلات</p>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $unit->is_active ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]' : 'bg-red-500' }}"></div>
                                <span class="text-xs font-bold {{ $unit->is_active ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $unit->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>
                            
                            @if($unit->allow_decimal)
                                <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-md" title="يقبل الكسور العشرية">
                                    0.00
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add/Edit Modal -->
    <div x-show="showAddModal || showEditModal" x-cloak class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="showAddModal || showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showAddModal || showEditModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100" @click.away="showAddModal = false; showEditModal = false;">
                    
                    <!-- Modal Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-black text-gray-900" x-text="showAddModal ? 'إضافة وحدة جديدة' : 'تعديل الوحدة'"></h3>
                        <button @click="showAddModal = false; showEditModal = false;" class="text-gray-400 hover:text-gray-500 bg-white rounded-lg w-8 h-8 flex items-center justify-center border border-gray-200 shadow-sm transition-all hover:bg-gray-50">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form :action="showAddModal ? '{{ route('units.store') }}' : '/units/' + form.id" method="POST" class="p-6 text-right">
                        @csrf
                        <input type="hidden" name="_method" :value="form._method">

                        <!-- Name & Symbol -->
                        <div class="grid grid-cols-3 gap-4 mb-5">
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">اسم الوحدة <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="form.name" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-bold text-sm" placeholder="مثال: كيلوجرام" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">الرمز <span class="text-red-500">*</span></label>
                                <input type="text" name="symbol" x-model="form.symbol" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-bold text-sm text-center" placeholder="kg" required>
                            </div>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">نوع القياس <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-3 gap-3">
                                <!-- Count -->
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="type" value="count" x-model="form.type" class="sr-only" @change="form.allow_decimal = false">
                                    <div class="rounded-xl border-2 px-3 py-4 text-center transition-all duration-200"
                                         :class="form.type === 'count' ? 'border-blue-600 bg-blue-50 text-blue-900 shadow-md transform -translate-y-1 ring-2 ring-blue-500 ring-offset-2' : 'border-gray-100 hover:border-blue-300 hover:bg-blue-50/30'">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 text-lg transition-colors"
                                             :class="form.type === 'count' ? 'bg-blue-200 text-blue-700' : 'bg-blue-100 text-blue-600'">
                                            <i class="fas fa-hashtag"></i>
                                        </div>
                                        <span class="text-sm font-bold">عدد</span>
                                    </div>
                                    <div class="absolute top-2 right-2 text-blue-600 transition-all duration-200"
                                         :class="form.type === 'count' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'">
                                        <i class="fas fa-check-circle text-lg drop-shadow-sm bg-white rounded-full"></i>
                                    </div>
                                </label>
                                
                                <!-- Weight -->
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="type" value="weight" x-model="form.type" class="sr-only" @change="form.allow_decimal = true">
                                    <div class="rounded-xl border-2 px-3 py-4 text-center transition-all duration-200"
                                         :class="form.type === 'weight' ? 'border-blue-600 bg-orange-50 text-orange-900 shadow-md transform -translate-y-1 ring-2 ring-blue-500 ring-offset-2' : 'border-gray-100 hover:border-blue-300 hover:bg-orange-50/30'">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 text-lg transition-colors"
                                             :class="form.type === 'weight' ? 'bg-orange-200 text-orange-700' : 'bg-orange-100 text-orange-600'">
                                            <i class="fas fa-weight-hanging"></i>
                                        </div>
                                        <span class="text-sm font-bold">وزن</span>
                                    </div>
                                    <div class="absolute top-2 right-2 text-blue-600 transition-all duration-200"
                                         :class="form.type === 'weight' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'">
                                        <i class="fas fa-check-circle text-lg drop-shadow-sm bg-white rounded-full"></i>
                                    </div>
                                </label>
                                
                                <!-- Volume -->
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="type" value="volume" x-model="form.type" class="sr-only" @change="form.allow_decimal = true">
                                    <div class="rounded-xl border-2 px-3 py-4 text-center transition-all duration-200"
                                         :class="form.type === 'volume' ? 'border-blue-600 bg-teal-50 text-teal-900 shadow-md transform -translate-y-1 ring-2 ring-blue-500 ring-offset-2' : 'border-gray-100 hover:border-blue-300 hover:bg-teal-50/30'">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 text-lg transition-colors"
                                             :class="form.type === 'volume' ? 'bg-teal-200 text-teal-700' : 'bg-teal-100 text-teal-600'">
                                            <i class="fas fa-flask"></i>
                                        </div>
                                        <span class="text-sm font-bold">حجم</span>
                                    </div>
                                    <div class="absolute top-2 right-2 text-blue-600 transition-all duration-200"
                                         :class="form.type === 'volume' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'">
                                        <i class="fas fa-check-circle text-lg drop-shadow-sm bg-white rounded-full"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Conversion Logic -->
                        <div class="mb-5 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-random text-gray-400"></i>
                                علاقة الوحدة
                            </label>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">الوحدة الأساسية (لتحويل إليها)</label>
                                    <select name="base_unit_id" x-model="form.base_unit_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-bold text-sm h-12">
                                        <option value="">هذه هي الوحدة الأساسية</option>
                                        @foreach($baseUnits as $base)
                                            <option value="{{ $base->id }}" 
                                                    x-show="form.type == '{{ $base->type }}' && form.id != {{ $base->id }}"
                                                    :selected="form.base_unit_id == {{ $base->id }}">
                                                {{ $base->name }} ({{ $base->symbol }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-[10px] text-gray-400 mt-1" x-show="!form.base_unit_id">
                                        اتركها فارغة إذا كانت هذه الوحدة هي المرجع الأساسي.
                                        <span class="block text-amber-500 mt-1" x-show="form.base_unit_id === '' && form.symbol">
                                            (مطلوب تحديد وحدة أساسية لتفعيل معدل التحويل)
                                        </span>
                                    </p>
                                </div>

                                <div x-show="form.base_unit_id" x-transition>
                                    <label class="block text-xs font-bold text-gray-500 mb-2">
                                        عامل التحويل: (1 <span x-text="form.symbol || 'وحدة'"></span> = كم وحدة أساسية؟)
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="any" name="conversion_rate" x-model="form.conversion_rate" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-bold text-sm text-left dir-ltr" placeholder="1000">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 text-xs font-bold bg-transparent">
                                            x BASE
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Toggles -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <!-- Allow Decimal Toggle -->
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:bg-gray-50 cursor-pointer transition-colors select-none group">
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_decimal" x-model="form.allow_decimal" class="sr-only peer">
                                    <div class="w-11 h-6 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"
                                         :class="form.allow_decimal ? 'bg-blue-600 after:translate-x-full rtl:after:-translate-x-full after:border-white' : 'bg-gray-200'"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-700 group-hover:text-blue-600 transition-colors">تقبل الكسور</span>
                                    <span class="text-[10px]" :class="form.allow_decimal ? 'text-blue-600 font-bold' : 'text-gray-400'">
                                        مثل: 0.5 كجم
                                    </span>
                                </div>
                            </label>

                            <!-- Is Active Toggle -->
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:bg-gray-50 cursor-pointer transition-colors select-none group">
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" x-model="form.is_active" class="sr-only peer">
                                    <div class="w-11 h-6 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"
                                         :class="form.is_active ? 'bg-blue-600 after:translate-x-full rtl:after:-translate-x-full after:border-white' : 'bg-gray-200'"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-700 group-hover:text-blue-600 transition-colors">الحالة</span>
                                    <span class="text-[10px]" :class="form.is_active ? 'text-blue-600 font-bold' : 'text-gray-400'" x-text="form.is_active ? 'نشط' : 'معطل'"></span>
                                </div>
                            </label>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex items-center gap-3 pt-2 text-sm">
                            <button type="button" @click="showAddModal = false; showEditModal = false;" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-colors">
                                إلغاء
                            </button>
                            <button type="submit" class="flex-[2] px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showDeleteModal" 
                     class="relative transform overflow-hidden rounded-2xl bg-white text-center shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm border border-gray-100 p-6">
                    
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <i class="fas fa-trash-alt text-2xl text-red-500"></i>
                    </div>
                    
                    <h3 class="text-lg font-black text-gray-900 mb-2">هل أنت متأكد؟</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        أنت على وشك حذف وحدة القياس "<span x-text="editingUnit?.name" class="font-bold text-gray-800"></span>".
                        <br>هذا الإجراء لا يمكن التراجع عنه.
                    </p>

                    <form :action="'/units/' + editingUnit?.id" method="POST" class="flex flex-col gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-200 active:scale-95">
                            نعم، احذف الوحدة
                        </button>
                        <button type="button" @click="showDeleteModal = false" class="w-full py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-colors">
                            إلغاء
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
