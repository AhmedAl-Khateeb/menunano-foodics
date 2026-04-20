@extends('layouts.app')

@section('title', 'فئات المخزون')

@section('main-content')
    <div class="container-fluid py-4" dir="rtl">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <div class="text-center text-md-end">
                <h4 class="font-weight-bold mb-1">فئات المخزون</h4>
                <p class="text-muted small mb-0">تصنيفات داخلية للمواد الخام</p>
            </div>

            <button type="button"
                class="btn btn-primary d-flex align-items-center gap-2 justify-content-center btn-responsive-width"
                data-toggle="modal" data-target="#addCategoryModal">
                <i class="fas fa-plus"></i>
                <span>إضافة فئة جديدة</span>
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @forelse($categories as $category)
                <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if ($category->cover)
                                    <img src="{{ url('storage/' . $category->cover) }}" alt="{{ $category->name }}"
                                        class="rounded-circle shadow-sm"
                                        style="width: 90px; height: 90px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 90px; height: 90px;">
                                        <i class="fas fa-cubes fa-2x text-secondary"></i>
                                    </div>
                                @endif
                            </div>

                            <h5 class="font-weight-bold text-dark mb-1">{{ $category->name }}</h5>
                            <p class="text-muted small mb-1">الكود: {{ $category->code ?: '-' }}</p>
                            <p class="text-muted small mb-2">{{ $category->description ?: 'بدون وصف' }}</p>
                            <p class="text-muted small mb-2">{{ $category->raw_materials_count ?? 0 }} مادة</p>

                            <span class="badge badge-{{ $category->is_active ? 'success' : 'secondary' }}">
                                {{ $category->is_active ? 'نشطة' : 'غير نشطة' }}
                            </span>
                        </div>

                        <div class="card-footer bg-white border-0 pt-0 pb-3 d-flex justify-content-center">
                            <button type="button" class="btn btn-info btn-sm mx-1"
                                onclick="openEditModal(
                                    {{ $category->id }},
                                    @js($category->name),
                                    @js($category->code),
                                    @js($category->description),
                                    {{ $category->is_active ? 'true' : 'false' }}
                                )">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('inventory.categories.destroy', $category->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3 opacity-50">
                        <i class="fas fa-layer-group fa-4x text-secondary"></i>
                    </div>
                    <p class="text-muted font-weight-bold">لا توجد فئات مخزون حالياً</p>
                    <p class="text-muted small">أضف فئات لتنظيم المواد الخام مثل: لحوم، خضروات، منظفات</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" dir="rtl">
                <form action="{{ route('inventory.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">إضافة فئة مخزون</h5>
                        <button type="button" class="close ml-0 mr-auto" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group text-right">
                            <label>اسم الفئة</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group text-right">
                            <label>الكود</label>
                            <input type="text" name="code" class="form-control">
                        </div>

                        <div class="form-group text-right">
                            <label>الوصف</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group text-right">
                            <label>الصورة</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>

                        <div class="form-check text-right">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                id="add_is_active" checked>
                            <label class="form-check-label mr-4" for="add_is_active">نشطة</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" dir="rtl">
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل الفئة</h5>
                        <button type="button" class="close ml-0 mr-auto" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group text-right">
                            <label>اسم الفئة</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>

                        <div class="form-group text-right">
                            <label>الكود</label>
                            <input type="text" name="code" id="editCode" class="form-control">
                        </div>

                        <div class="form-group text-right">
                            <label>الوصف</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group text-right">
                            <label>تغيير الصورة</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>

                        <div class="form-check text-right">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                id="editIsActive">
                            <label class="form-check-label mr-4" for="editIsActive">نشطة</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <ol class="float-sm-right mb-0 p-0" style="list-style: none;">
            <li>
                <a href="{{ route('dashboard') }}" class="btn btn-success"
                    style="color: #fff; transition: all 0.2s ease-in-out;"
                    onmouseover="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff'; this.style.color='#fff';"
                    onmouseout="this.style.backgroundColor=''; this.style.borderColor=''; this.style.color='#fff';">
                    الرئيسية
                </a>
            </li>
        </ol>
    </div>

    <script>
        function openEditModal(id, name, code, description, isActive) {
            document.getElementById('editName').value = name || '';
            document.getElementById('editCode').value = code || '';
            document.getElementById('editDescription').value = description || '';
            document.getElementById('editIsActive').checked = !!isActive;
            document.getElementById('editCategoryForm').action = "/inventory/categories/" + id;
            $('#editCategoryModal').modal('show');
        }
    </script>

    <style>
        .btn-responsive-width {
            width: 100%;
        }

        @media (min-width: 768px) {
            .btn-responsive-width {
                width: auto !important;
            }
        }
    </style>
@endsection
