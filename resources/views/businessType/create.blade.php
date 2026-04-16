@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة نوع نشاط جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('business-types.index') }}">أنواع النشاط</a>
                        </li>
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
                            <h3 class="card-title">بيانات نوع النشاط</h3>
                        </div>

                        <form method="POST" action="{{ route('business-types.store') }}">
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

                                <div class="form-group">
                                    <label for="name">اسم نوع النشاط</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        placeholder="أدخل اسم نوع النشاط"
                                        value="{{ old('name') }}"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input
                                        type="text"
                                        name="slug"
                                        id="slug"
                                        class="form-control"
                                        placeholder="مثال: restaurant أو retail"
                                        value="{{ old('slug') }}"
                                    >
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            name="is_active"
                                            id="is_active"
                                            value="1"
                                            class="custom-control-input"
                                            {{ old('is_active', 1) ? 'checked' : '' }}
                                        >
                                        <label class="custom-control-label" for="is_active">
                                            نوع نشاط نشط
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="{{ route('business-types.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection