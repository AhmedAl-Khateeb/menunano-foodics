@extends('layouts.app')

@section('title', 'إضافة باقة جديدة')

@section('main-content')
    <div class="container py-4" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="package-page-header mb-4">
                    <div>
                        <h2 class="mb-1 text-center">
                            <i class="fas fa-box-open ml-2"></i>
                            إضافة باقة جديدة
                        </h2>
                        <p class="mb-0 text-muted text-center">أنشئ باقة جديدة وحدد نوع النشاط والمميزات والصلاحيات الخاصة بها</p>
                    </div>
                </div>

                <div class="card package-card shadow-sm border-0">
                    <div class="card-header package-card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-layer-group ml-2"></i>
                            بيانات الباقة
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 pr-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('packages.store') }}" method="POST">
                            @csrf

                            <div class="form-section mb-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اسم الباقة</label>
                                        <input type="text" name="name" class="form-control custom-input"
                                            value="{{ old('name') }}" placeholder="مثال: الباقة الذهبية" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">نوع النشاط</label>
                                        <select name="business_type_id" class="form-control custom-input" required>
                                            <option value="">اختر نوع النشاط</option>
                                            @foreach ($businessTypes as $businessType)
                                                <option value="{{ $businessType->id }}"
                                                    {{ old('business_type_id') == $businessType->id ? 'selected' : '' }}>
                                                    {{ $businessType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="description" class="form-control custom-input" rows="4"
                                            placeholder="اكتب وصفًا مختصرًا عن الباقة">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">السعر</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text price-addon">$</span>
                                            </div>
                                            <input type="number" step="0.01" name="price"
                                                class="form-control custom-input" value="{{ old('price') }}"
                                                placeholder="0.00" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">المدة (بالأيام)</label>
                                        <input type="number" name="duration" class="form-control custom-input"
                                            value="{{ old('duration') }}" placeholder="مثال: 30" required>
                                    </div>
                                </div>
                            </div>

                            <div class="divider-title mb-3">
                                <span><i class="fas fa-star ml-2"></i>المميزات</span>
                            </div>

                            <div class="mb-4">
                                <div id="features-wrapper">
                                    @php
                                        $oldFeatures = old('features', ['']);
                                    @endphp

                                    @foreach ($oldFeatures as $feature)
                                        <div class="input-group mb-2 feature-row">
                                            <input type="text" name="features[]" class="form-control custom-input"
                                                value="{{ $feature }}" placeholder="أدخل ميزة">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-feature">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="add-feature" class="btn btn-outline-primary mt-2">
                                    <i class="fas fa-plus ml-1"></i>
                                    إضافة ميزة
                                </button>
                            </div>

                            <div class="divider-title mb-3">
                                <span><i class="fas fa-user-shield ml-2"></i>الصلاحيات</span>
                            </div>

                            <div class="mb-4">
                                <div class="row">
                                    @foreach ($availablePermissions as $permission)
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <label class="permission-wrapper w-100 mb-0">
                                                <input type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $permission['key'] }}"
                                                    class="permission-checkbox d-none"
                                                    {{ in_array($permission['key'], old('permissions', [])) ? 'checked' : '' }}>

                                                <div class="permission-card">
                                                    <div class="permission-top d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <div class="permission-icon">
                                                                <i class="{{ $permission['icon'] }}"></i>
                                                            </div>
                                                            <div class="mr-2">
                                                                <div class="permission-label">{{ $permission['label'] }}</div>
                                                                <small class="text-muted">{{ $permission['group'] }}</small>
                                                            </div>
                                                        </div>

                                                        <div class="permission-check">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="divider-title mb-3">
                                <span><i class="fas fa-toggle-on ml-2"></i>الحالة</span>
                            </div>

                            <div class="mb-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="is_active" value="1" class="custom-control-input"
                                        id="is_active" {{ old('is_active', 1) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">الباقة مفعلة</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap action-area">
                                <a href="{{ route('packages.index') }}" class="btn btn-light border px-4">
                                    <i class="fas fa-times ml-1"></i>
                                    إلغاء
                                </a>

                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save ml-1"></i>
                                    حفظ الباقة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-feature').addEventListener('click', function() {
            let wrapper = document.getElementById('features-wrapper');
            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2', 'feature-row');
            div.innerHTML = `
                <input type="text" name="features[]" class="form-control custom-input" placeholder="أدخل ميزة">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-feature">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            wrapper.appendChild(div);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-feature')) {
                const row = e.target.closest('.feature-row');
                const rows = document.querySelectorAll('.feature-row');

                if (rows.length > 1) {
                    row.remove();
                } else {
                    row.querySelector('input').value = '';
                }
            }
        });
    </script>

    <style>
        .package-page-header h2 {
            font-weight: 800;
            color: #1f2937;
        }

        .package-card {
            border-radius: 18px;
            overflow: hidden;
        }

        .package-card-header {
            background: linear-gradient(135deg, #0d6efd, #1f7bf2);
            color: #fff;
            padding: 18px 24px;
            border: 0;
        }

        .form-label {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .custom-input {
            border-radius: 12px;
            min-height: 48px;
            border: 1px solid #d9dee7;
            box-shadow: none !important;
        }

        textarea.custom-input {
            min-height: auto;
        }

        .custom-input:focus {
            border-color: #0d6efd;
        }

        .price-addon {
            border-radius: 12px 0 0 12px;
            background: #f8f9fa;
            border: 1px solid #d9dee7;
            border-left: 0;
        }

        .divider-title {
            position: relative;
            text-align: right;
            margin-top: 10px;
        }

        .divider-title span {
            display: inline-block;
            background: #f8fafc;
            color: #1f2937;
            font-weight: 800;
            padding: 8px 14px;
            border-radius: 10px;
        }

        .feature-row .btn {
            border-radius: 0 12px 12px 0;
            min-width: 52px;
        }

        .permission-card {
            border: 1px solid #dfe5ec;
            border-radius: 16px;
            padding: 16px;
            background: #fff;
            cursor: pointer;
            transition: 0.25s ease;
            height: 100%;
        }

        .permission-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
            border-color: #b8d4ff;
        }

        .permission-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #eef4ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .permission-label {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .permission-check {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            color: transparent;
            transition: 0.2s ease;
            flex-shrink: 0;
        }

        .permission-checkbox:checked + .permission-card {
            border-color: #0d6efd;
            background: #f4f8ff;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.12);
        }

        .permission-checkbox:checked + .permission-card .permission-check {
            border-color: #0d6efd;
            background: #0d6efd;
            color: #fff;
        }

        .action-area {
            border-top: 1px solid #eceff3;
            padding-top: 20px;
            margin-top: 10px;
        }

        @media (max-width: 767.98px) {
            .action-area {
                gap: 10px;
            }

            .action-area .btn {
                width: 100%;
            }
        }
    </style>
@endsection