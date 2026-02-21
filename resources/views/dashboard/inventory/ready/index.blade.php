@extends('layouts.app')

@section('title', 'المنتجات الجاهزة')

@section('main-content')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body, .font-cairo { font-family: 'Cairo', sans-serif !important; }
    .card-product { border-radius: 16px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; text-align: right; }
    .card-product:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .badge-soft-blue { background-color: rgba(37, 99, 235, 0.1); color: #2563eb; }
    .btn-brand-primary { background: #2563eb; color: white; border-radius: 10px; border: none; font-weight: 600; }
    .btn-brand-primary:hover { background: #1d4ed8; color: white; }
    .form-label { display: block; text-align: right; width: 100%; }
    .text-end { text-align: right !important; }
</style>

<div class="container-fluid py-4 font-cairo" dir="rtl">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="text-center text-md-end w-100 w-md-auto">
            <h4 class="font-weight-bold mb-1">المنتجات الجاهزة</h4>
            <p class="text-muted small mb-0">إدارة مبيعات ومخزون المنتجات الجاهزة للبيع مباشرة</p>
        </div>
        <div class="w-100 w-md-auto d-grid d-md-flex justify-content-md-end">
            <a href="{{ route('inventory.ready.create') }}" class="btn btn-brand-primary d-flex align-items-center justify-content-center gap-2 px-4 shadow-sm">
                <i class="fas fa-plus"></i>
                <span>إضافة منتج جديد</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="position-relative mb-4">
        <button class="btn btn-white shadow-sm border rounded-circle position-absolute top-50 start-0 translate-middle-y z-index-1 d-none d-md-block" 
                style="width: 32px; height: 32px; padding: 0; margin-right: -10px;" 
                onclick="document.getElementById('cat-scroll-container').scrollBy({left: 200, behavior: 'smooth'})">
            <i class="fas fa-chevron-right" style="color: #2563eb;"></i>
        </button>

        <div id="cat-scroll-container" class="d-flex overflow-auto py-2 gap-2 px-1 px-md-4 align-items-center" style="scrollbar-width: none;">
            <a href="{{ route('inventory.ready.index') }}" 
               class="btn btn-sm {{ !request('category_id') || request('category_id') == 'all' ? 'btn-dark' : 'btn-outline-dark' }} text-nowrap rounded-pill px-3 px-md-4">
                الكل
            </a>
            @foreach($categories as $category)
                <a href="{{ route('inventory.ready.index', ['category_id' => $category->id]) }}" 
                   class="btn btn-sm {{ request('category_id') == $category->id ? 'btn-dark' : 'btn-outline-dark' }} text-nowrap rounded-pill px-3 px-md-4">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <button class="btn btn-white shadow-sm border rounded-circle position-absolute top-50 end-0 translate-middle-y z-index-1 d-none d-md-block" 
                style="width: 32px; height: 32px; padding: 0; margin-left: -10px;" 
                onclick="document.getElementById('cat-scroll-container').scrollBy({left: -200, behavior: 'smooth'})">
            <i class="fas fa-chevron-left" style="color: #2563eb;"></i>
        </button>
    </div>

    <div class="row g-2 g-md-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card card-product h-100">
                    <div class="card-product-media position-relative" style="height: 160px;">
                        @if($product->cover)
                            <img src="{{ asset('storage/' . $product->cover) }}" class="card-img-top w-100 h-100 object-cover" style="border-radius: 16px 16px 0 0;" alt="{{ $product->name }}">
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center" style="border-radius: 16px 16px 0 0;">
                                <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 end-0 m-1 badge bg-dark text-white opacity-75 text-xxs">
                            {{ $product->category->name ?? 'بدون' }}
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="font-weight-bold mb-0 text-truncate text-sm" style="max-width: 85%;">{{ $product->name }}</h6>
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary p-0 mb-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 text-right">
                                    <li><a class="dropdown-item" href="{{ route('inventory.ready.edit', $product->id) }}">تعديل</a></li>
                                    <li><a class="dropdown-item text-danger" href="#">حذف</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-xs text-muted d-none d-md-inline">السعر:</span>
                            <span class="text-sm font-weight-bold text-primary">{{ number_format($product->price, 2) }}</span>
                        </div>

                        <div class="bg-light rounded-sm p-1 p-md-2 mb-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-1">
                                <i class="fas fa-warehouse text-xxs text-muted"></i>
                                <span class="text-xxs font-weight-bold d-none d-md-inline">المخزون:</span>
                            </div>
                            <span class="badge {{ ($product->inventory->current_quantity ?? 0) > 5 ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} text-xxs">
                                {{ $product->inventory->current_quantity ?? 0 }}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                         <div class="d-flex flex-column gap-2">
                             <a href="{{ route('inventory.ready.edit', $product->id) }}" class="btn btn-brand-primary w-100 text-sm py-2 shadow-sm">
                                <i class="fas fa-edit ms-1"></i> تعديل المنتج والأحجام
                             </a>
                             <div class="d-flex gap-1">
                                 <button class="btn btn-sm btn-outline-secondary flex-grow-1 text-xxs px-1" onclick="openAdjustModal({{ $product->id }}, '{{ $product->name }}', {{ $product->sizes->map(fn($s) => ['id' => $s->id, 'size' => $s->size])->toJson() }})">
                                    <i class="fas fa-sliders-h ms-1"></i> جرد سريع
                                 </button>
                                  <a href="{{ route('inventory.ready.history', $product->id) }}" class="btn btn-sm btn-outline-info flex-grow-1 text-xxs px-1 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-history"></i>
                                 </a>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-box-open fa-4x text-gray-200"></i>
                </div>
                <p class="text-muted">لا توجد منتجات جاهزة حالياً</p>
                <a href="{{ route('inventory.ready.create') }}" class="btn btn-primary btn-sm mt-3">ابدأ بإضافة منتجك الأول</a>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>



<style>
    .bg-success-soft { background-color: rgba(45, 206, 137, 0.15) !important; }
    .bg-danger-soft { background-color: rgba(245, 54, 92, 0.15) !important; }
    .rounded-sm { border-radius: 8px; }
    /* RTL Fixes */
    .text-end { text-align: right !important; }
</style>

    <!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" dir="rtl">
            <form id="adjustStockForm" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold text-dark">تعديل المخزون: <span id="productNameTitle" style="color: #2563eb;"></span></h5>
                    <button type="button" class="btn-close ms-0 me-auto shadow-none" data-bs-dismiss="modal" style="margin-left: 0; margin-right: auto;"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3" id="sizeSelectGroup" style="display: none;">
                        <label class="form-label text-sm font-weight-bold text-end w-100">الحجم (اختياري)</label>
                        <select name="size_id" id="sizeSelect" class="form-select border-2 shadow-none text-end">
                            <option value="">المنتج الرئيسي (بدون حجم)</option>
                        </select>
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
                    <div class="mb-0">
                        <label class="form-label text-sm font-weight-bold text-end w-100">تم بواسطة / ملاحظات</label>
                        <textarea name="description" class="form-control border-2 shadow-none text-end" rows="2" placeholder="سبب الحركة..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-brand-primary px-4 py-2">حفظ التعديل</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAdjustModal(id, name, sizes = []) {
        document.getElementById('productNameTitle').innerText = name;
        document.getElementById('adjustStockForm').action = "/inventory/ready/" + id + "/adjust";
        
        const sizeSelect = document.getElementById('sizeSelect');
        const sizeGroup = document.getElementById('sizeSelectGroup');
        
        // Reset select
        sizeSelect.innerHTML = '<option value="">المنتج الرئيسي (بدون حجم)</option>';
        
        if (sizes && sizes.length > 0) {
            sizes.forEach(size => {
                const option = document.createElement('option');
                option.value = size.id;
                option.text = size.size; // Assuming 'size' is the name of the size field
                sizeSelect.appendChild(option);
            });
            sizeGroup.style.display = 'block';
        } else {
            sizeGroup.style.display = 'none';
        }

        new bootstrap.Modal(document.getElementById('adjustStockModal')).show();
    }

    function toggleCostField(type) {
        const costGroup = document.getElementById('costFieldGroup');
        if (type === 'purchase') {
            costGroup.style.display = 'block';
        } else {
            costGroup.style.display = 'none';
        }
    }
</script>
@endsection
