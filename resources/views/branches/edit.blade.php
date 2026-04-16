@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تعديل فرع</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('branches.index') }}">الفروع</a>
                        </li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">بيانات الفرع</h3>
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
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        placeholder="أدخل اسم الفرع"
                                        value="{{ old('name', $branch->name) }}"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="code">الكود</label>
                                    <input
                                        type="text"
                                        name="code"
                                        id="code"
                                        class="form-control"
                                        placeholder="أدخل كود الفرع"
                                        value="{{ old('code', $branch->code) }}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="phone">الهاتف</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control"
                                        placeholder="أدخل رقم الهاتف"
                                        value="{{ old('phone', $branch->phone) }}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input
                                        type="text"
                                        name="address"
                                        id="address"
                                        class="form-control"
                                        placeholder="أدخل عنوان الفرع"
                                        value="{{ old('address', $branch->address) }}"
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
                                            {{ old('is_active', $branch->is_active) ? 'checked' : '' }}
                                        >
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection