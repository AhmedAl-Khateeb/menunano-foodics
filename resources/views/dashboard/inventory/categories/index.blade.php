@extends('layouts.app')

@section('title', 'فئات المخزون')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="text-center text-md-end">
            <h4 class="font-weight-bold mb-1">فئات المخزون (Inventory Categories)</h4>
            <p class="text-muted small">تصنيفات داخلية للمواد الخام والأصناف</p>
        </div>
        <button class="btn btn-primary d-flex align-items-center gap-2 justify-content-center btn-responsive-width" onclick="$('#addCategoryModal').modal('show')">
            <i class="fas fa-plus"></i>
            <span>إضافة فئة جديدة</span>
        </button>
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

    <div class="row g-3">
        @forelse($categories as $category)
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative group-hover">
                    <div class="card-body p-3 text-center">
                        <div class="mb-3 position-relative d-inline-block">
                            @if($category->cover)
                                <img src="{{ $category->cover_url }}" class="rounded-circle shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-gradient-light rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                    <i class="fas fa-cubes fa-2x text-secondary opacity-5"></i>
                                </div>
                            @endif
                        </div>
                        <h6 class="font-weight-bold mb-1 text-dark">{{ $category->name }}</h6>
                        <p class="text-xs text-muted mb-0">{{ $category->products_count ?? 0 }} أصناف</p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3 d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-info rounded-circle" style="width: 32px; height: 32px; padding: 0;" 
                                onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')">
                            <i class="fas fa-pen text-xxs"></i>
                        </button>
                        <form action="{{ route('inventory.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0;">
                                <i class="fas fa-trash text-xxs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3 opacity-5">
                    <i class="fas fa-layer-group fa-4x text-gray-300"></i>
                </div>
                <p class="text-muted font-weight-bold">لا توجد فئات مخزون حالياً</p>
                <p class="text-muted small">أضف فئات لتنظيم المواد الخام (مثل: لحوم، خضروات، منظفات...)</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" dir="rtl">
            <form action="{{ route('inventory.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">إضافة فئة مخزون</h5>
                    <button type="button" class="btn-close ms-0 me-auto shadow-none" data-bs-dismiss="modal" style="margin-left: 0; margin-right: auto;"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">اسم الفئة</label>
                        <input type="text" name="name" class="form-control border-2 shadow-none text-end" required placeholder="مثال: خضروات">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">صورة (اختياري)</label>
                        <input type="file" name="image" class="form-control border-2 shadow-none text-end" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary px-4">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" dir="rtl">
            <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">تعديل الفئة</h5>
                    <button type="button" class="btn-close ms-0 me-auto shadow-none" data-bs-dismiss="modal" style="margin-left: 0; margin-right: auto;"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">اسم الفئة</label>
                        <input type="text" name="name" id="editName" class="form-control border-2 shadow-none text-end" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm font-weight-bold text-end w-100">تغيير الصورة (اختياري)</label>
                        <input type="file" name="image" class="form-control border-2 shadow-none text-end" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary px-4">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, name) {
        document.getElementById('editName').value = name;
        document.getElementById('editCategoryForm').action = "/inventory/categories/" + id;
        $('#editCategoryModal').modal('show');
    }
</script>

<style>
    .bg-gradient-light { background: linear-gradient(310deg, #f6f9fc 0%, #e9ecef 100%); }
    .text-end { text-align: right !important; }
    
    /* Custom Responsive Button width */
    .btn-responsive-width { width: 100%; }
    @media (min-width: 768px) {
        .btn-responsive-width { width: auto !important; }
    }
</style>
@endsection
