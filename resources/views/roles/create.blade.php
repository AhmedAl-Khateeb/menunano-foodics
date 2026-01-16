@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة دور جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الأدوار</a></li>
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
                            <h3 class="card-title float-right">بيانات الدور</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
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
                                    <label for="name">اسم الدور</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="أدخل اسم الدور" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label>الصلاحيات</label>
                                    <div class="row">
                                        @foreach ($permissions as $group => $perms)
                                            <div class="col-md-12">
                                                <div class="card card-secondary card-outline collapsed-card1">
                                                    <div class="card-header">
                                                        <h5 class="card-title">{{ __('permissions.' . $group) }}</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach ($perms as $permission)
                                                                <div class="col-md-3">
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $permission->name }}"
                                                                            id="perm_{{ $permission->id }}"
                                                                            style="width: 18px; height: 18px;">
                                                                        <label class="mb-0 mx-2"
                                                                            for="perm_{{ $permission->id }}"
                                                                            style="cursor: pointer;">
                                                                            {{ __('permissions.' . $permission->name) }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
