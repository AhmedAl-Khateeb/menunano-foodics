@extends('layouts.app')

@section('title', 'إضافة متجر جديد')

@section('main-content')
    <div class="container mt-4" dir="rtl" style="text-align: right;">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white py-3">
                <h3 class="card-title font-weight-bold mb-0">إضافة مدير / متجر جديد</h3>
            </div>
            <div class="card-body">
                {{-- عرض الأخطاء --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">الاسم الشخصي</label>
                            <input type="text" name="name" class="form-control" required
                                placeholder="مثال: أحمد محمد">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">اسم المتجر (Slug)</label>
                            <input type="text" name="store_name" class="form-control" required
                                placeholder="مثال: my-store">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" required
                                placeholder="example@mail.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">الهاتف</label>
                            <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">كلمة المرور</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">لوجو المتجر</label>
                            <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3 text-center">
                            <div id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail shadow-sm"
                                    style="max-height: 120px; border-radius: 15px;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">الحالة</label>
                        <select name="status" class="form-control custom-select" required>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>

                    <hr class="my-5">

                    {{-- قسم استنساخ البيانات --}}
                    <div class="bg-light p-4 rounded-lg mb-4 border border-info"
                        style="border-right: 5px solid #17a2b8 !important;">
                        <h5 class="font-weight-bold text-info mb-3">
                            <i class="fas fa-copy ml-2"></i> استنساخ بيانات من متجر موجود (اختياري)
                        </h5>
                        <p class="text-muted small">يمكنك اختيار متجر لاستنساخ أقسامه ومنتجاته للمتجر الجديد بسرعة.</p>

                        <div class="mb-3">
                            <label class="form-label">اختر المتجر المصدر</label>
                            <select name="clone_from_user_id" id="cloneSource" class="form-control custom-select">
                                <option value="">-- لا يوجد (بدء بمتجر فارغ) --</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->store_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="categoriesContainer" style="display: none;">
                            <label class="form-label font-weight-bold mb-2">اختر الأقسام المراد استنساخها:</label>
                            <div id="categoriesList" class="row px-3">
                                {{-- سيتم تعبئته عبر JS --}}
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-info"
                                    onclick="selectAllCategories(true)">تحديد الكل</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="selectAllCategories(false)">إلغاء التحديد</button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2 pt-3">
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm">حفظ المتجر</button>
                        <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary px-4">رجوع للكل</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // معاينة الصورة
            const imageInput = document.getElementById('imageInput');
            if (imageInput) {
                imageInput.onchange = evt => {
                    const [file] = evt.target.files;
                    if (file) {
                        document.getElementById('imagePreview').src = URL.createObjectURL(file);
                        document.getElementById('imagePreviewContainer').style.display = 'block';
                    }
                }
            }

            // جلب الأقسام عند اختيار متجر
            const cloneSource = document.getElementById('cloneSource');
            if (cloneSource) {
                cloneSource.addEventListener('change', function() {
                    const userId = this.value;
                    const container = document.getElementById('categoriesContainer');
                    const list = document.getElementById('categoriesList');

                    console.log('Target user selected:', userId);

                    // Reset state
                    container.style.display = 'none';
                    list.innerHTML =
                        '<div class="col-12 text-info mb-3"><i class="fas fa-spinner fa-spin ml-2"></i> جاري تحميل الأقسام...</div>';

                    if (!userId) {
                        list.innerHTML = '';
                        return;
                    }

                    container.style.display = 'block';

                    // Construct URL relative to the current host
                    const fetchUrl = `/super/admins/get-categories/${userId}`;
                    console.log('Fetching from URL:', fetchUrl);

                    fetch(fetchUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(`HTTP ${response.status}: ${text}`)
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);
                            list.innerHTML = '';
                            if (data.length === 0) {
                                list.innerHTML =
                                    '<div class="col-12 text-danger pb-3">عذراً، هذا المتجر لا يحتوي على أي أقسام مسجلة.</div>';
                            } else {
                                data.forEach(cat => {
                                    list.innerHTML += `
                            <div class="col-md-4 mb-3">
                                <div class="p-3 border rounded shadow-sm bg-white d-flex align-items-center selection-card" style="cursor: pointer; transition: all 0.2s; border-right: 4px solid #17a2b8 !important;" onclick="document.getElementById('cat_${cat.id}').click()">
                                    <input class="category-checkbox" type="checkbox" name="categories[]" value="${cat.id}" id="cat_${cat.id}" checked 
                                        style="width: 22px; height: 22px; cursor: pointer; margin-left: 12px; transform: scale(1.2);"
                                        onclick="event.stopPropagation()">
                                    <label class="form-check-label mb-0 font-weight-bold" for="cat_${cat.id}" style="cursor: pointer; flex-grow: 1; user-select: none;">
                                        ${cat.name}
                                    </label>
                                </div>
                            </div>
                        `;
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            list.innerHTML = `<div class="col-12 text-danger border p-3 rounded bg-white">
                    <i class="fas fa-exclamation-triangle ml-1"></i>
                    حدث خطأ أثناء تحميل الأقسام: ${error.message}
                </div>`;
                        });
                });
            }

            function selectAllCategories(status) {
                document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = status);
            }
        </script>

        <style>
            .selection-card:hover {
                background-color: #f0f9ff !important;
                border-color: #007bff !important;
                transform: translateY(-2px);
            }
        </style>
    @endpush
@endsection
