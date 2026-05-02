@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تعديل فرع</h1>
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
                            <h3 class="mb-0 text-center w-100">
                                بيانات الفرع
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('branches.update', $branch->id) }}">
                            @csrf
                            @method('PUT')

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

                                <div class="form-group">
                                    <label for="name">اسم الفرع</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="أدخل اسم الفرع" value="{{ old('name', $branch->name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="code">الكود</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        placeholder="أدخل كود الفرع" value="{{ old('code', $branch->code) }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">الهاتف</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="أدخل رقم الهاتف" value="{{ old('phone', $branch->phone) }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="أدخل عنوان الفرع" value="{{ old('address', $branch->address) }}">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            class="custom-control-input"
                                            {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            فرع نشط
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">تحديث</button>
                                <a href="{{ route('branches.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </form>


                        <div class="card mt-4 text-right" dir="rtl">
                            <div class="card-header bg-dark text-white">
                                <h3 class="mb-0 text-center w-100">
                                    ربط مدير أو موظف بالفرع
                                </h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('branches.assign-manager', $branch->id) }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label class="d-block text-right">اختر المستخدم</label>
                                        <select name="user_id" class="form-control text-right" required>
                                            <option value="">-- اختر المستخدم --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} - {{ $user->role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="d-block text-right">الدور داخل الفرع</label>
                                        <select name="role" class="form-control text-right" required>
                                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>
                                                مدير فرع
                                            </option>
                                            <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>
                                                كاشير
                                            </option>
                                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                                                موظف
                                            </option>
                                        </select>

                                        <small class="text-muted d-block text-right mt-1">
                                            هذا الدور يتم حفظه في جدول branch_users داخل عمود role.
                                        </small>
                                    </div>

                                    <div class="border rounded p-3 mb-3 bg-light">
                                        <div class="form-group mb-2">
                                            <label class="d-flex align-items-center justify-content-start mb-0">
                                                <input type="checkbox" name="is_primary_manager" value="1"
                                                    {{ old('is_primary_manager') ? 'checked' : '' }}
                                                    style="margin-left: 8px;">
                                                <span>مدير أساسي للفرع</span>
                                            </label>
                                        </div>

                                        {{-- <div class="form-group mb-0">
                                            <label class="d-flex align-items-center justify-content-start mb-0">
                                                <input type="checkbox" name="can_manage_permissions" value="1"
                                                    {{ old('can_manage_permissions') ? 'checked' : '' }}
                                                    style="margin-left: 8px;">
                                                <span>يمكنه إدارة الصلاحيات</span>
                                            </label>
                                        </div> --}}
                                    </div>

                                    @php
                                        $selectedPermissions = old('permissions', []);
                                    @endphp

                                    <div class="border rounded p-3 bg-white text-right">
                                        <label class="font-weight-bold d-block mb-3 text-right">
                                            الصلاحيات
                                        </label>

                                        @foreach ($branchPermissions as $groupName => $permissions)
                                            <div class="mb-4">
                                                <h6 class="font-weight-bold text-primary mb-2">
                                                    {{ $groupName }}
                                                </h6>

                                                <div class="row">
                                                    @foreach ($permissions as $permission)
                                                        <div class="col-md-4 col-sm-6 mb-2">
                                                            <label
                                                                class="d-flex align-items-center justify-content-start mb-0">
                                                                <input type="checkbox" name="permissions[]"
                                                                    value="{{ $permission['key'] }}"
                                                                    {{ in_array($permission['key'], $selectedPermissions) ? 'checked' : '' }}
                                                                    style="margin-left: 8px;">

                                                                <span>
                                                                    @if (!empty($permission['icon']))
                                                                        <i class="{{ $permission['icon'] }} ml-1"></i>
                                                                    @endif

                                                                    {{ $permission['label'] }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">
                                        ربط المستخدم بالفرع
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
