@extends('layouts.app')
@section('main-content')
<div class="container">
    <h3 class="mb-3">إضافة وسيلة دفع</h3>

    <form method="POST" action="{{ route('payment-methods.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked value="1">
            <label class="form-check-label" for="is_active">مفعّل</label>
        </div>

        <button class="btn btn-primary">حفظ</button>
        <a href="{{ route('payment-methods.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
