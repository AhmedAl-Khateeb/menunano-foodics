@extends('layouts.app')
@section('main-content')
<div class="container">
    <h3 class="mb-3">تعديل وسيلة الدفع</h3>

    <form method="POST" action="{{ route('payment-methods.update', $method->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $method->name) }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $method->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" required value="{{ old('phone', $method->phone) }}">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $method->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">مفعّل</label>
        </div>

        <button class="btn btn-primary">حفظ</button>
        <a href="{{ route('payment-methods.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
