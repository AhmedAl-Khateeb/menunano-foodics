@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة فرع جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('branches.index') }}">الفروع</a>
                        </li>
                        <li class="breadcrumb-item active">إضافة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">بيانات الفرع</h3>
                        </div>

                        <form method="POST" action="{{ route('branches.store') }}">
                            @csrf

                            <div class="card-body text-right">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <h5 class="font-weight-bold mb-3 text-primary">
                                    بيانات الفرع
                                </h5>

                                <div class="form-group">
                                    <label for="name">اسم الفرع</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="أدخل اسم الفرع" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="code">الكود</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        placeholder="أدخل كود الفرع" value="{{ old('code') }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">الهاتف</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="أدخل عنوان الفرع" value="{{ old('address') }}">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            class="custom-control-input" {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            فرع نشط
                                        </label>
                                    </div>
                                </div>

                                <hr>

                                <div class="card border mt-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0 font-weight-bold">
                                            ربط مدير أو موظف بالفرع
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>اختر المستخدم</label>
                                            <select name="manager_user_id" class="form-control">
                                                <option value="">-- بدون مدير إضافي الآن --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('manager_user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }} - {{ $user->role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>الدور داخل الفرع</label>
                                            <select name="branch_role" class="form-control">
                                                <option value="manager"
                                                    {{ old('branch_role') == 'manager' ? 'selected' : '' }}>
                                                    مدير فرع
                                                </option>
                                                <option value="cashier"
                                                    {{ old('branch_role') == 'cashier' ? 'selected' : '' }}>
                                                    كاشير
                                                </option>
                                                <option value="staff"
                                                    {{ old('branch_role') == 'staff' ? 'selected' : '' }}>
                                                    موظف
                                                </option>
                                            </select>
                                            <small class="text-muted">
                                                هذا الدور يتم حفظه في جدول branch_users داخل عمود role.
                                            </small>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" name="is_primary_manager" value="1"
                                                class="custom-control-input" id="primary_manager"
                                                {{ old('is_primary_manager') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="primary_manager">
                                                مدير أساسي للفرع
                                            </label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="can_manage_permissions" value="1"
                                                class="custom-control-input" id="manage_permissions"
                                                {{ old('can_manage_permissions') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="manage_permissions">
                                                يمكنه إدارة الصلاحيات
                                            </label>
                                        </div>

                                        <div class="border rounded p-3 bg-white">
                                            <label class="font-weight-bold d-block mb-2">الصلاحيات</label>

                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" name="permissions[]" value="orders.access"
                                                    class="custom-control-input" id="orders_access"
                                                    {{ in_array('orders.access', old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="orders_access">
                                                    إدارة الطلبات
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" name="permissions[]" value="pos.access"
                                                    class="custom-control-input" id="pos_access"
                                                    {{ in_array('pos.access', old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="pos_access">
                                                    نقطة البيع
                                                </label>
                                            </div>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" value="reports.sales"
                                                    class="custom-control-input" id="reports_sales"
                                                    {{ in_array('reports.sales', old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="reports_sales">
                                                    تقرير المبيعات
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    حفظ
                                </button>

                                <a href="{{ route('branches.index') }}" class="btn btn-default">
                                    إلغاء
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
