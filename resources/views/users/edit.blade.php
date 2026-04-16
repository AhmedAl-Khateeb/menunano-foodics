@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تعديل المستخدم</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">تعديل</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">تعديل بيانات المستخدم</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body text-right">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="أدخل الاسم" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="أدخل البريد الإلكتروني" value="{{ old('email', $user->email) }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="password">كلمة المرور (اتركه فارغاً إذا لم ترد التغيير)</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="كلمة المرور">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="تأكيد كلمة المرور">
                                </div>
                                <div class="form-group">
                                    <label for="role_id">الدور (الوظيفة)</label>
                                    <select class="form-control" id="role_id" name="role_id" required>
                                        <option value="">اختر الدور</option>
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}"
                                                {{ old('role_id', $user->roles->first()?->id ?? ($user->role === 'cashier' && $r->id === 'cashier' ? 'cashier' : null)) == $r->id ? 'selected' : '' }}>
                                                {{ $r->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>الفرع</label>

                                    <select name="branch_id" class="form-control">
                                        <option value="">اختر الفرع</option>

                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <small class="text-muted">اختر الفرع التابع له المستخدم</small>
                                </div>

                                <div class="form-group">
                                    <label for="image">صورة المستخدم</label>
                                    <input type="file" name="image" id="image" class="form-control">

                                    @if (isset($user) && $user->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="user-image"
                                                width="80" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">حفظ التغييرات</button>
                                <a href="{{ route('users.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
