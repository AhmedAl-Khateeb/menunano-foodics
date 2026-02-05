@extends('layouts.app')

@section('title', 'تعديل بيانات المتجر')

@section('main-content')
    <div class="container mt-4" dir="rtl" style="text-align: right;">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white py-3">
                <h3 class="card-title font-weight-bold mb-0">تعديل بيانات المدير / المتجر</h3>
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

                <form action="{{ route('admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">اسم المتجر</label>
                            <input type="text" name="store_name" class="form-control" value="{{ $admin->store_name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">كلمة المرور (اتركه فارغاً إذا لا تريد
                                التغيير)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">الهاتف</label>
                            <input type="text" name="phone" class="form-control" value="{{ $admin->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">الباقة</label>
                            <select name="package_id" class="form-control custom-select">
                                <option value="">-- اختر الباقة --</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}"
                                        {{ $admin->package_id == $package->id ? 'selected' : '' }}>
                                        {{ $package->name }} ({{ $package->duration }} يوم)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">لوجو المتجر</label>
                            <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3 text-center">
                            <div id="imagePreviewContainer">
                                @if ($admin->image)
                                    <img id="imagePreview" src="{{ asset('storage/app/public/' . $admin->image) }}"
                                        alt="Logo" class="img-thumbnail shadow-sm"
                                        style="max-height: 120px; border-radius: 15px;">
                                    <p class="text-muted small mt-1">اللوجو الحالي</p>
                                @else
                                    <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail shadow-sm"
                                        style="max-height: 120px; border-radius: 15px; display: none;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">تاريخ بدء الاشتراك</label>
                            <input type="date" name="subscription_start" id="subscription_start" class="form-control"
                                value="{{ old('subscription_start', $admin->subscription_start ? $admin->subscription_start->format('Y-m-d') : '') }}">
                            @if ($admin->subscription_end)
                                <div class="alert alert-success mt-2 py-2 small border-0 shadow-sm">
                                    تاريخ انتهاء الاشتراك:
                                    <strong>{{ $admin->subscription_end->format('Y-m-d') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">الحالة</label>
                            <select name="status" class="form-control custom-select">
                                <option value="1" {{ $admin->status == 1 ? 'selected' : '' }}>نشط / مفعل</option>
                                <option value="0" {{ $admin->status == 0 ? 'selected' : '' }}>موقوف / غير مفعل
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2 pt-3">
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm">تحديث
                            البيانات</button>
                        <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary px-4">رجوع للكل</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('imageInput').onchange = evt => {
                const [file] = evt.target.files;
                if (file) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'inline-block';

                    // تحديث النص التوضيحي إذا وجد
                    const txt = preview.nextElementSibling;
                    if (txt && txt.tagName === 'P') {
                        txt.innerHTML = 'اللوجو المختار (جديد)';
                        txt.classList.remove('text-muted');
                        txt.classList.add('text-primary', 'font-weight-bold');
                    }
                }
            }
        </script>
    @endpush
@endsection
