@extends('layouts.app')

@section('title', 'المواد الخام')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="text-center text-md-end w-100 w-md-auto">
            <h4 class="font-weight-bold mb-1">المواد الخام</h4>
            <p class="text-muted small mb-0">إدارة المواد الأولية والمكونات الداخلة في التصنيع</p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto justify-content-center justify-content-md-end">
            <a href="{{ route('inventory.raw.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm">
                <i class="fas fa-plus"></i>
                <span>مادة جديدة</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats Row (Optional Idea, good for modern look) --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-primary-soft text-primary rounded-circle p-3">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 font-weight-bold">{{ $rawMaterials->total() }}</h6>
                        <small class="text-muted">إجمالي المواد</small>
                    </div>
                </div>
            </div>
        </div>
        {{-- Add more stats if needed --}}
    </div>

    {{-- Items Grid --}}
    <div class="row g-3">
        @forelse($rawMaterials as $item)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card shadow-sm border-0 h-100 overflow-hidden group-hover">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar bg-light border text-center shadow-sm rounded-circle">
                                     {{-- If image exists show it, else icon --}}
                                     <i class="fas fa-leaf text-success mt-3" style="font-size: 1.2rem;"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h6 class="font-weight-bold mb-0 text-truncate text-dark" title="{{ $item->name }}">{{ $item->name }}</h6>
                                    <span class="text-xs text-muted">{{ $item->category->name ?? 'عام' }}</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary p-0 mb-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 text-right">
                                    <li><a class="dropdown-item" href="{{ route('inventory.raw.edit', $item->id) }}"><i class="fas fa-pen ms-2 text-xs"></i> تعديل</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash ms-2 text-xs"></i> حذف</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded p-2 mb-3 border border-light">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-xs text-muted">الرصيد:</span>
                                <span class="badge {{ ($item->inventory->current_quantity ?? 0) > 0 ? 'bg-white text-dark border' : 'bg-danger-soft text-danger' }}">
                                    {{ $item->inventory->current_quantity ?? 0 }} {{ $item->inventory->unit->name ?? 'وحدة' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-xs text-muted">التكلفة:</span>
                                <span class="text-xs font-weight-bold">{{ number_format($item->inventory->purchase_price ?? 0, 2) }} ج</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                             <button class="btn btn-sm btn-outline-dark flex-grow-1 text-xs py-2 shadow-none" 
                                     onclick="openAdjustModal({{ $item->id }}, '{{ $item->name }}', {{ $item->inventory->current_quantity ?? 0 }})">
                                <i class="fas fa-sliders-h ms-1"></i> تسوية المخزون
                             </button>
                             <a href="{{ route('inventory.raw.history', $item->id) }}" class="btn btn-sm btn-outline-secondary text-xs py-2 shadow-none" title="سجل الحركات">
                                <i class="fas fa-history"></i>
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3 opacity-5">
                    <i class="fas fa-box-open fa-4x text-gray-300"></i>
                </div>
                <p class="text-muted font-weight-bold">لا توجد مواد خام حالياً</p>
                <a href="{{ route('inventory.raw.create') }}" class="btn btn-primary btn-sm mt-3">إضافة مادة جديدة</a>
            </div>
        @endforelse
    </div>

    @if($rawMaterials->hasPages())
        <div class="mt-4">
            {{ $rawMaterials->links() }}
        </div>
    @endif
</div>

<!-- Quick Add Modal -->
<div class="modal fade" id="quickAddModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" dir="rtl">
            <form action="{{ route('inventory.raw.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold text-dark">إضافة مادة خام سريعة</h5>
                    <button type="button" class="btn-close ms-0 me-auto shadow-none" data-bs-dismiss="modal" style="margin-left: 0; margin-right: auto;"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">اسم المادة الخام</label>
                        <input type="text" name="name" class="form-control form-control-lg border-2 shadow-none text-end" required placeholder="مثال: لحم، دقيق، سكر...">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold text-end w-100">سعر الشراء</label>
                            <div class="input-group">
                                <span class="input-group-text border-2 bg-light">ج</span>
                                <input type="number" step="0.01" name="purchase_price" class="form-control border-2 shadow-none text-end" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold text-end w-100">وحدة الشراء</label>
                            <select name="purchase_unit_id" class="form-select border-2 shadow-none text-end" required>
                                <option value="">اختر...</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Category Selection (Optional) --}}
                     <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">الفئة (اختياري)</label>
                         {{-- Note: We might need to pass categories to this view, or load them via ajax. For quick add, usually default or None is fine, OR we can check if $categories exists --}}
                         {{-- I will assume $categories is NOT passed to index, so I'll create a simple input or remove it for QUICK add. 
                              Actually, RawMaterialController::index doesn't pass categories. I should update Controller to pass specific Internal categories if needed. 
                              For now let's skip category in quick add or let it be null (default). 
                         --}}
                    </div>
                    
                    <div class="mb-0">
                        <label class="form-label text-sm font-weight-bold text-end w-100">الكمية الافتتاحية</label>
                        <input type="number" step="0.001" name="current_quantity" class="form-control border-2 shadow-none text-end" value="0">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary px-4 py-2">حفظ المادة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" dir="rtl">
            <form id="adjustStockForm" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold text-dark">تعديل المخزون: <span id="productNameTitle" class="text-primary"></span></h5>
                    <button type="button" class="btn-close ms-0 me-auto shadow-none" data-bs-dismiss="modal" style="margin-left: 0; margin-right: auto;"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="alert alert-light border text-center py-2 mb-3">
                        <span class="text-xs text-muted">الرصيد الحالي:</span>
                        <span class="font-weight-bold text-dark mx-1" id="currentStockDisplay">0</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">نوع الحركة</label>
                        <select name="type" class="form-select border-2 shadow-none text-end" required onchange="toggleCostField(this.value)">
                            <option value="purchase">شراء / توريد (+)</option>
                            <option value="waste">هالك / تالف (-)</option>
                            <option value="adjustment">تسوية جرد (+/-)</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-sm font-weight-bold text-end w-100">الكمية</label>
                            <input type="number" step="0.001" name="quantity" class="form-control border-2 shadow-none text-end" required placeholder="0.00">
                        </div>
                        <div class="col-md-6 mb-3" id="costFieldGroup">
                            <label class="form-label text-sm font-weight-bold text-end w-100">سعر الوحدة (اختياري)</label>
                            <input type="number" step="0.01" name="unit_cost" class="form-control border-2 shadow-none text-end" placeholder="السعر الحالي">
                        </div>
                    </div>
                    
                    <div class="mb-3 text-center" id="stockFeedback">
                        {{-- Validation messages will appear here --}}
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-sm font-weight-bold text-end w-100">تم بواسطة / ملاحظات</label>
                        <textarea name="description" class="form-control border-2 shadow-none text-end" rows="2" placeholder="سبب الحركة..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" id="adjustSubmitBtn" disabled>حفظ التعديل</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentStock = 0;

    function openAdjustModal(id, name, stock) {
        document.getElementById('productNameTitle').innerText = name;
        document.getElementById('adjustStockForm').action = "/inventory/raw/" + id + "/adjust";
        
        // Store current stock for calculation
        currentStock = parseFloat(stock);
        document.getElementById('currentStockDisplay').innerText = currentStock;
        
        // Reset form and validation
        document.getElementById('adjustStockForm').reset();
        validateStock(); // Initial check
        
        new bootstrap.Modal(document.getElementById('adjustStockModal')).show();
    }

    function toggleCostField(type) {
        const costGroup = document.getElementById('costFieldGroup');
        if (type === 'purchase') {
            costGroup.style.display = 'block';
        } else {
            costGroup.style.display = 'none';
        }
        validateStock();
    }

    function validateStock() {
        const type = document.querySelector('select[name="type"]').value;
        const quantityInput = document.querySelector('input[name="quantity"]');
        const quantity = parseFloat(quantityInput.value);
        const feedback = document.getElementById('stockFeedback');
        const submitBtn = document.getElementById('adjustSubmitBtn');
        
        if (isNaN(quantity) || quantity === 0) {
            feedback.innerHTML = '<span class="text-muted text-xs">أدخل الكمية لرؤية الأثر على المخزون.</span>';
            submitBtn.disabled = true;
            return;
        }

        let newQuantity = currentStock;
        let isValid = true;
        let message = '';
        let color = 'text-info';

        if (type === 'purchase') {
            if (quantity < 0) {
                isValid = false;
                message = 'لا يمكن إدخال قيمة سالبة في عملية الشراء.';
                color = 'text-danger';
            } else {
                newQuantity += quantity;
                message = `سيتم <b>إضافة</b> ${quantity} للمخزون. الرصيد الجديد: <b>${newQuantity}</b>`;
                color = 'text-success';
            }
        } else if (type === 'waste') {
             if (quantity < 0) {
                isValid = false;
                message = 'أدخل قيمة موجبة للهالك (سيقوم النظام بخصمها تلقائياً).';
                color = 'text-danger';
            } else {
                newQuantity -= quantity;
                if (newQuantity < 0) {
                    isValid = false;
                    message = `هذه الكمية أكبر من الرصيد الحالي (${currentStock})!`;
                    color = 'text-danger';
                } else {
                    message = `سيتم <b>خصم</b> ${quantity} من المخزون. الرصيد الجديد: <b>${newQuantity}</b>`;
                    color = 'text-warning';
                }
            }
        } else if (type === 'adjustment') {
            newQuantity += quantity;
             if (newQuantity < 0) {
                isValid = false;
                message = `هذه الكمية ستجعل الرصيد بالسالب (${newQuantity})!`;
                color = 'text-danger';
            } else {
                if (quantity > 0) {
                    message = `تعديل بالزيادة (+). الرصيد الجديد: <b>${newQuantity}</b>`;
                    color = 'text-success';
                } else {
                    message = `تعديل بالنقص (-). الرصيد الجديد: <b>${newQuantity}</b>`;
                    color = 'text-warning';
                }
            }
        }

        feedback.innerHTML = `<span class="${color} text-xs font-weight-bold">${message}</span>`;
        submitBtn.disabled = !isValid;
    }

    // Attach event listeners
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('select[name="type"]').addEventListener('change', validateStock);
        document.querySelector('input[name="quantity"]').addEventListener('input', validateStock);
    });
</script>

<style>
    .bg-primary-soft { background-color: rgba(94, 114, 228, 0.15) !important; color: #5e72e4; }
    .bg-danger-soft { background-color: rgba(245, 54, 92, 0.15) !important; color: #f5365c; }
    .avatar { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .text-end { text-align: right !important; }
</style>
@endsection
