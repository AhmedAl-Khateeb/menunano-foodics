@extends('layouts.app')

@section('title', 'إضافة مادة خام جديدة')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                     <h4 class="font-weight-bold mb-1">إضافة مادة خام جديدة</h4>
                     <p class="text-muted small mb-0">أدخل بيانات المادة الخام لإضافتها للمخزون</p>
                </div>
                <a href="{{ route('inventory.raw.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-right ms-2"></i> إلغاء
                </a>
            </div>

            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                    <form action="{{ route('inventory.raw.store') }}" method="POST">
                        @csrf
                        
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm mb-4">
                                <i class="fas fa-check-circle ms-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <i class="fas fa-exclamation-circle ms-2"></i> {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        {{-- Basic Information Section --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-3">البيانات الأساسية</h6>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label font-weight-bold text-sm">اسم المادة الخام <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-lg border-2 shadow-none text-end" 
                                           placeholder="مثال: لحم مفروم، طماطم، دقيق..." value="{{ old('name') }}" required autofocus>
                                    @error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label font-weight-bold text-sm">فئة المخزون (Category) <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select form-select-lg border-2 shadow-none text-end" required>
                                        <option value="" disabled selected>اختر الفئة...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-xs">
                                        <a href="{{ route('inventory.categories.index') }}" class="text-primary text-decoration-none">
                                            <i class="fas fa-plus-circle"></i> إدارة الفئات
                                        </a>
                                    </div>
                                    @error('category_id') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">

                        {{-- Inventory & Costing Section --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-3">بيانات التكلفة والمخزون</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold text-sm">وحدة القياس / الشراء <span class="text-danger">*</span></label>
                                    <select name="purchase_unit_id" class="form-select form-select-lg border-2 shadow-none text-end" required>
                                        <option value="" disabled selected>اختر الوحدة (مثال: كجم، لتر)...</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('purchase_unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('purchase_unit_id') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                                    @if($units->isEmpty())
                                        <div class="alert alert-warning mt-2 text-xs">
                                            <i class="fas fa-exclamation-triangle"></i> لا توجد وحدات قياس. <a href="{{ route('units.index') }}" class="alert-link">أضف وحدات أولاً</a>.
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold text-sm">التكلفة (سعر الشراء) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text border-2 bg-light text-muted">ج.م</span>
                                        <input type="number" step="0.01" name="purchase_price" class="form-control border-2 shadow-none text-end" 
                                               placeholder="0.00" value="{{ old('purchase_price') }}" required>
                                    </div>
                                    <small class="text-muted text-xs">سعر الوحدة الواحدة</small>
                                    @error('purchase_price') <div class="text-danger text-xs">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="bg-gray-50 rounded p-3 border border-light mt-2">
                                        <div class="form-check form-switch ps-0 d-flex align-items-center gap-3">
                                            <label class="form-check-label text-dark font-weight-bold ms-3" for="hasOpeningStock">إضافة رصيد افتتاحي؟</label>
                                            <input class="form-check-input ms-0" type="checkbox" id="hasOpeningStock" onchange="toggleOpeningStock()" {{ old('current_quantity') ? 'checked' : '' }}>
                                        </div>
                                        <div class="mt-3" id="openingStockGroup" style="display: {{ old('current_quantity') ? 'block' : 'none' }};">
                                            <label class="form-label font-weight-bold text-sm">الكمية الحالية</label>
                                            <input type="number" step="0.001" name="current_quantity" class="form-control border-2 shadow-none text-end" 
                                                   placeholder="0.00" value="{{ old('current_quantity', 0) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-check ms-2"></i> حفظ المادة
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleOpeningStock() {
        const checkbox = document.getElementById('hasOpeningStock');
        const group = document.getElementById('openingStockGroup');
        const input = group.querySelector('input');
        
        if (checkbox.checked) {
            group.style.display = 'block';
        } else {
            group.style.display = 'none';
            input.value = 0;
        }
    }
</script>

<style>
    .form-control-lg, .form-select-lg { font-size: 0.95rem; }
    .border-2 { border-width: 2px !important; }
    .bg-gray-50 { background-color: #f9fafb !important; }
    .text-end { text-align: right !important; }
</style>
@endsection
