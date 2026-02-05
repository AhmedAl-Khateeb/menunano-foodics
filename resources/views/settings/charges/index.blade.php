@extends('layouts.app')

@section('main-content')
<div x-data="{
    showAddModal: false,
    showEditModal: false,
    showDeleteModal: false,
    editingCharge: null,
    form: {
        id: null,
        name: '',
        classification: 'tax', // tax, fee
        type: 'percentage', // percentage, fixed
        value: '',
        is_inclusive: false,
        is_inclusive: false,
        applicable_order_types: ['dining_in', 'takeaway', 'delivery'],
        description: '',
        is_active: true,
        _method: 'POST'
    },
    
    resetForm() {
        this.form = {
            id: null,
            name: '',
            classification: 'tax', // tax, fee
            type: 'percentage',
            value: '',
            is_inclusive: false,
            is_inclusive: false,
            applicable_order_types: ['dining_in', 'takeaway', 'delivery'],
            description: '',
            is_active: true,
            _method: 'POST'
        };
        this.editingCharge = null;
    },
    
    openAddModal() {
        this.resetForm();
        this.showAddModal = true;
    },
    
    openEditModal(charge) {
        this.editingCharge = charge;
        this.form = {
            id: charge.id,
            name: charge.name,
            classification: charge.classification,
            type: charge.type,
            value: charge.value,
            is_inclusive: Boolean(charge.is_inclusive),
            is_inclusive: Boolean(charge.is_inclusive),
            applicable_order_types: charge.applicable_order_types || [],
            description: charge.description || '',
            is_active: Boolean(charge.is_active),
            _method: 'PUT'
        };
        this.showEditModal = true;
    },
    
    openDeleteModal(charge) {
        this.editingCharge = charge;
        this.showDeleteModal = true;
    }
}">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm flex-shrink-0 border border-indigo-100/50">
                        <i class="fas fa-percent text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight font-sans">
                            الضرائب والرسوم
                        </h1>
                        <p class="text-sm font-medium text-gray-500">
                            إدارة ضرائب القيمة المضافة ورسوم الخدمة
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openAddModal()" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 active:scale-95">
                        <i class="fas fa-plus"></i>
                        <span>إضافة ضريبة/رسم</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Charges Grid -->
        @if($charges->isEmpty())
            <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-invoice-dollar text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">لا توجد ضرائب معرفة</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">قم بتعريف الضرائب والرسوم (مثل القيمة المضافة 15٪) لتطبيقها على المنتجات والطلبات.</p>
                <button @click="openAddModal()" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                    <i class="fas fa-plus mr-2"></i> إضافة أول ضريبة
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($charges as $charge)
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-50 to-transparent rounded-bl-full -mr-10 -mt-10 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold
                                        {{ $charge->type == 'percentage' ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600' }}">
                                        @if($charge->type == 'percentage')
                                            <i class="fas fa-percentage"></i>
                                        @else
                                            <i class="fas fa-coins"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $charge->name }}</h3>
                                        <p class="text-xs text-gray-500 font-mono">{{ $charge->type == 'percentage' ? 'نسبة مئوية' : 'مبلغ ثابت' }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button @click="openEditModal({{ $charge }})" class="text-gray-400 hover:text-indigo-600 transition-colors p-1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="openDeleteModal({{ $charge }})" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-baseline gap-1 mb-4">
                                <span class="text-3xl font-black text-gray-900 tracking-tight">{{ floatval($charge->value) }}</span>
                                <span class="text-sm font-bold text-gray-500">{{ $charge->type == 'percentage' ? '%' : 'SAR' }}</span>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $charge->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                    <span class="text-xs font-bold {{ $charge->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $charge->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </div>
                                @if($charge->classification === 'tax')
                                     <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $charge->is_inclusive ? 'bg-indigo-100 text-indigo-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $charge->is_inclusive ? 'شامل الضريبة' : 'غير شامل' }}
                                     </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">
                                        رسم خدمة
                                    </span>
                                @endif
                            </div>

                            <div class="mt-2 flex gap-1">
                            </div>

                            <div class="mt-2 flex flex-wrap gap-1">
                                @if(is_array($charge->applicable_order_types))
                                    @if(in_array('dining_in', $charge->applicable_order_types))
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">ديكور</span>
                                    @endif
                                    @if(in_array('takeaway', $charge->applicable_order_types))
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-700">سفري</span>
                                    @endif
                                    @if(in_array('delivery', $charge->applicable_order_types))
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700">توصيل</span>
                                    @endif
                                @endif
                            </div>
                            @if($charge->description)
                                <div class="group/tooltip relative">
                                    <i class="fas fa-info-circle text-gray-300 hover:text-gray-500 cursor-help"></i>
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover/tooltip:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-20">
                                        {{Str::limit($charge->description, 50)}}
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modals (Add/Edit Logic similar to Units) -->
    <!-- Add/Edit Modal -->
    <div x-show="showAddModal || showEditModal" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="showAddModal = false; showEditModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900" x-text="showEditModal ? 'تعديل البيانات' : 'إضافة ضريبة / رسم جديد'"></h3>
                        <button @click="showAddModal = false; showEditModal = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <form :action="showEditModal ? '{{ url('settings/charges') }}/' + form.id : '{{ route('charges.store') }}'" method="POST" id="chargeForm">
                        @csrf
                        <input type="hidden" name="_method" :value="form._method">

                        <!-- Name -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">المسمى <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="form.name" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
                                placeholder="مثلاً: ضريبة القيمة المضافة أو رسوم توصيل">
                        </div>

                        <!-- Classification (Tax vs Fee) -->
                        <div class="mb-5 bg-gray-50 p-3 rounded-xl border border-gray-100 flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="classification" value="tax" x-model="form.classification" class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm font-bold text-gray-700">ضريبة (Tax)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="classification" value="fee" x-model="form.classification" class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm font-bold text-gray-700">رسم (Fee)</span>
                            </label>
                        </div>

                        <!-- Type & Value Row -->
                        <div class="grid grid-cols-2 gap-4 mb-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">النوع <span class="text-red-500">*</span></label>
                                <select name="type" x-model="form.type" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 bg-white">
                                    <option value="percentage">نسبة مئوية (%)</option>
                                    <option value="fixed">مبلغ ثابت (SAR)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">القيمة <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="value" x-model="form.value" step="0.01" min="0" required
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5 pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold sm:text-sm" x-text="form.type == 'percentage' ? '%' : 'SAR'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Is Inclusive Toggle -->
                        <div class="mb-5" x-show="form.classification === 'tax'" x-transition>
                            <label class="flex items-center justify-between cursor-pointer group bg-white border border-gray-200 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <span class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-700">مضمن في السعر؟</span>
                                    <span class="text-xs text-gray-500">هل السعر المعلن للمنتج يشمل هذه الضريبة؟</span>
                                </span>
                                <div class="relative">
                                    <input type="checkbox" name="is_inclusive" class="sr-only peer" x-model="form.is_inclusive">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                </div>
                            </label>
                        </div>

                        <!-- Applies To Scope -->
                        <div class="mb-5 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <label class="block text-sm font-bold text-gray-700 mb-3">نطاق التطبيق</label>
                            <div class="flex flex-col gap-2">
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded hover:bg-gray-100">
                                    <input type="checkbox" value="dining_in" x-model="form.applicable_order_types" class="text-indigo-600 focus:ring-indigo-500 rounded">
                                    <span class="text-sm text-gray-700 font-bold">داخلي (Dining In)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded hover:bg-gray-100">
                                    <input type="checkbox" value="takeaway" x-model="form.applicable_order_types" class="text-indigo-600 focus:ring-indigo-500 rounded">
                                    <span class="text-sm text-gray-700 font-bold">سفري (Takeaway)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded hover:bg-gray-100">
                                    <input type="checkbox" value="delivery" x-model="form.applicable_order_types" class="text-indigo-600 focus:ring-indigo-500 rounded">
                                    <span class="text-sm text-gray-700 font-bold">توصيل (Delivery)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">وصف (اختياري)</label>
                            <textarea name="description" x-model="form.description" rows="2"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="وصف قصير للضريبة..."></textarea>
                        </div>

                        <!-- Is Active Toggle -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="flex items-center justify-between cursor-pointer group">
                                <span class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">حالة التفعيل</span>
                                    <span class="text-xs text-gray-500 mt-0.5" x-text="form.is_active ? 'نشط ويمكن استخدامه' : 'معطل مؤقتاً'"></span>
                                </span>
                                <div class="relative">
                                    <input type="checkbox" name="is_active" class="sr-only peer" x-model="form.is_active">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </div>
                            </label>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 mt-8">
                            <button type="button" @click="showAddModal = false; showEditModal = false" class="flex-1 bg-white text-gray-700 px-4 py-3 rounded-xl border border-gray-300 font-bold hover:bg-gray-50 transition-colors">
                                إلغاء
                            </button>
                            <button type="submit" class="flex-[2] bg-indigo-600 text-white px-4 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                                <span x-text="showEditModal ? 'حفظ التغييرات' : 'إضافة'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-16 sm:w-16 mb-4">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                    </div>
                    <div class="text-center sm:text-right">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">تأكيد الحذف</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                هل أنت متأكد من حذف <span class="font-bold text-gray-900" x-text="editingCharge?.name"></span>؟
                                <br>لا يمكن التراجع عن هذا الإجراء.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <form :action="'{{ url('settings/charges') }}/' + editingCharge?.id" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                            حذف نهائي
                        </button>
                    </form>
                    <button type="button" @click="showDeleteModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
