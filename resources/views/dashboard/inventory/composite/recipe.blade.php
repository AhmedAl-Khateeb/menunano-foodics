@extends('layouts.app')

@section('title', 'إدارة الوصفة - ' . $product->name)

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="text-center text-md-end w-100 w-md-auto">
            <h4 class="font-weight-bold mb-1">إدارة مكونات الوصفة (Recipe)</h4>
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                <span class="text-muted small">المنتج:</span>
                <span class="badge bg-primary">{{ $product->name }}</span>
            </div>
        </div>
        <div class="w-100 w-md-auto d-flex justify-content-center justify-content-md-end">
            <a href="{{ route('inventory.composite.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="fas fa-arrow-right"></i>
                <span>عودة للقائمة</span>
            </a>
            <a href="{{ route('inventory.composite.edit', $product->id) }}#sizes-table" class="btn btn-outline-primary d-flex align-items-center gap-2 me-2">
                <i class="fas fa-ruler-combined"></i>
                <span>إدارة الأحجام</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2">
                    <ul class="nav nav-pills nav-fill gap-2">
                        <li class="nav-item">
                            <a class="nav-link {{ is_null($selectedSizeId) ? 'active' : '' }}" href="{{ route('inventory.composite.recipe.edit', $product->id) }}">
                                <i class="fas fa-cube ms-1"></i> الافتراضي (بدون حجم)
                            </a>
                        </li>
                        @foreach($product->sizes as $size)
                            <li class="nav-item">
                                <a class="nav-link {{ $selectedSizeId == $size->id ? 'active' : '' }}" 
                                   href="{{ route('inventory.composite.recipe.edit', ['id' => $product->id, 'size_id' => $size->id]) }}">
                                    <i class="fas fa-expand ms-1"></i> {{ $size->size }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Ingredient Card -->
        <div class="col-lg-4 mb-4 order-lg-last">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h6 class="font-weight-bold mb-0 text-end">
                        @if($selectedSizeId)
                            إضافة مكون للحجم: <span class="text-primary">{{ $product->sizes->find($selectedSizeId)->size }}</span>
                        @else
                            إضافة مكون (افتراضي)
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.composite.recipe.add', $product->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold text-end w-100">نوع المكون</label>
                            <div class="d-flex gap-2">
                                <div class="form-check flex-fill p-0">
                                    <input type="radio" class="btn-check" name="product_size_id" id="size_common" value="" {{ is_null($selectedSizeId) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary w-100 text-xs" for="size_common">مشترك (لكل الأحجام)</label>
                                </div>
                                @if($selectedSizeId)
                                <div class="form-check flex-fill p-0">
                                    <input type="radio" class="btn-check" name="product_size_id" id="size_specific" value="{{ $selectedSizeId }}" checked>
                                    <label class="btn btn-outline-primary w-100 text-xs" for="size_specific">خاص بهذا الحجم</label>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-sm font-weight-bold text-end w-100">المادة الخام</label>
                            <select name="ingredient_id" class="form-select border-2 shadow-none text-end" required>
                                <option value="">اختر مادة خام...</option>
                                @foreach($rawMaterials as $material)
                                    <option value="{{ $material->id }}">
                                        {{ $material->name }} 
                                        ({{ $material->inventory->current_quantity ?? 0 }} {{ $material->inventory->unit->name ?? '' }} متاح)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-sm font-weight-bold text-end w-100">الكمية</label>
                                <input type="number" step="0.001" name="quantity" class="form-control border-2 shadow-none text-end" required placeholder="0.00">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-sm font-weight-bold text-end w-100">الوحدة</label>
                                <select name="unit_id" class="form-select border-2 shadow-none text-end" required>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus ms-1"></i> إضافة للوصفة
                        </button>
                    </form>
                    
                    <div class="alert alert-light border mt-4 mb-0">
                        <small class="text-muted d-block mb-1 text-end">
                            <i class="fas fa-info-circle text-info ms-1"></i>
                            تلميح:
                        </small>
                        <p class="text-xs text-secondary mb-0 text-end">
                            يمكنك إضافة مكونات "مشتركة" تدخل في كل الأحجام (مثل الخبز أو الزيت)، ومكونات "خاصة" يختلف وزنها حسب الحجم.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipe List Card -->
        <div class="col-lg-8 mb-4 order-lg-first">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0">مكونات الوصفة</h6>
                    <span class="badge bg-light text-dark">{{ $product->recipes->count() }} مكونات إجمالاً</span>
                </div>
                <div class="card-body">
                    @php
                        $commonIngredients = $product->recipes->where('product_size_id', null);
                        $specificIngredients = $product->recipes->where('product_size_id', '!=', null);
                    @endphp

                    @if($specificIngredients->isNotEmpty())
                        <div class="mb-2 text-end">
                            <span class="badge bg-primary-soft text-primary font-weight-bold">مكونات خاصة بالحجم: {{ $product->sizes->find($selectedSizeId)->size }}</span>
                        </div>
                        @foreach($specificIngredients as $recipe)
                            @include('dashboard.inventory.composite._recipe_item', ['recipe' => $recipe])
                        @endforeach
                        <hr class="my-4">
                    @endif

                    @if($commonIngredients->isNotEmpty())
                        <div class="mb-2 text-end">
                            <span class="badge bg-secondary-soft text-secondary font-weight-bold">المكونات المشتركة (لكافة الأحجام)</span>
                        </div>
                        @foreach($commonIngredients as $recipe)
                            @include('dashboard.inventory.composite._recipe_item', ['recipe' => $recipe])
                        @endforeach
                    @endif

                    @if($product->recipes->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3 opacity-5">
                                <i class="fas fa-blender fa-4x text-gray-300"></i>
                            </div>
                            <p class="text-muted font-weight-bold">لا توجد مكونات في الوصفة</p>
                            <p class="text-muted small">قم بإضافة المواد الخام من النموذج لإنشاء الوصفة.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-2 { border-width: 2px !important; }
    .text-end { text-align: right !important; }
    .bg-primary-soft { background-color: rgba(94, 114, 228, 0.1); }
    .bg-secondary-soft { background-color: rgba(131, 146, 171, 0.1); }
    .text-xs { font-size: 0.75rem !important; }
</style>
@endsection
