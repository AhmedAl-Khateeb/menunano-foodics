@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة عامل توصيل</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('delivery_men.index') }}">عمال التوصيل</a></li>
                        <li class="breadcrumb-item active">إضافة إضافة</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-primary">
                        <div class="card-header text-right">
                            <h3 class="card-title float-right">بيانات عامل التوصيل</h3>
                        </div>
                        <form action="{{ route('delivery_men.store') }}" method="POST">
                            @csrf
                            <div class="card-body text-right">
                                <div class="form-group mb-3 text-right">
                                    <label for="name">الاسم <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="أدخل اسم المندوب" value="{{ old('name') }}" required>
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group mb-3 text-right">
                                    <label for="phone">رقم الهاتف</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror text-right" id="phone" placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}">
                                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group mb-3 text-right">
                                    <label for="commission_percent">نسبة العمولة (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="commission_percent" class="form-control @error('commission_percent') is-invalid @enderror text-right" id="commission_percent" placeholder="أدخل نسبة العمولة" value="{{ old('commission_percent', 0) }}">
                                    <small class="text-muted d-block">النسبة المئوية التي يحصل عليها المندوب من رسوم التوصيل أو قيمة الطلب.</small>
                                    @error('commission_percent') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group mb-3 text-right">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : 'checked' }}>
                                        <label class="custom-control-label" for="is_active">تفعيل حساب المندوب</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('delivery_men.index') }}" class="btn btn-default ml-2">إلغاء</a>
                                <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
