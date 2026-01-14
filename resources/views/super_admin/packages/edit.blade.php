@extends('layouts.app')

@section('title', 'تعديل الباقة')

@section('main-content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-box-open me-2"></i>
                        تعديل الباقة
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('packages.update', $package->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- اسم الباقة --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">اسم الباقة</label>
                            <input type="text" name="name" class="form-control form-control-lg"
                                   value="{{ old('name', $package->name) }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الوصف --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">الوصف</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- السعر --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">السعر</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                           value="{{ old('price', $package->price) }}" required>
                                </div>
                                @error('price')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- المدة بالأيام --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">المدة (أيام)</label>
                                <input type="number" name="duration" class="form-control"
                                       value="{{ old('duration', $package->duration) }}" required>
                                @error('duration')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- حالة الباقة --}}
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active"
                                       id="is_active" value="1" {{ $package->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">الباقة نشطة</label>
                            </div>
                        </div>

                        {{-- المميزات --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">المميزات</label>
                            <div id="features-wrapper">
                                @if($package->features->count() > 0)
                                    @foreach($package->features as $index => $feature)
                                        <div class="input-group mb-2 feature-item">
                                            <input type="hidden" name="features[{{ $index }}][id]" value="{{ $feature->id }}">
                                            <input type="text" name="features[{{ $index }}][text]"
                                                   class="form-control" placeholder="أدخل ميزة"
                                                   value="{{ old('features.'.$index.'.text', $feature->text) }}">
                                            <button type="button" class="btn btn-danger remove-feature">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 feature-item">
                                        <input type="hidden" name="features[0][id]" value="">
                                        <input type="text" name="features[0][text]" class="form-control" placeholder="أدخل ميزة">
                                        <button type="button" class="btn btn-danger remove-feature">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-feature" class="btn btn-outline-primary mt-2">
                                <i class="fas fa-plus me-1"></i> إضافة ميزة
                            </button>
                            @error('features.*')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- أزرار الحفظ والإلغاء --}}
                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>
                                حفظ التعديلات
                            </button>
                            <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript لإضافة/حذف الميزات --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إضافة ميزة جديدة
    document.getElementById('add-feature').addEventListener('click', function() {
        let wrapper = document.getElementById('features-wrapper');
        let index = wrapper.querySelectorAll('.feature-item').length;
        let div = document.createElement('div');
        div.classList.add('input-group', 'mb-2', 'feature-item');
        div.innerHTML = `
            <input type="hidden" name="features[${index}][id]" value="">
            <input type="text" name="features[${index}][text]" class="form-control" placeholder="أدخل ميزة">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="fas fa-trash"></i>
            </button>
        `;
        wrapper.appendChild(div);
    });

    // حذف ميزة
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            let featureItem = e.target.closest('.feature-item');
            if (document.querySelectorAll('.feature-item').length > 1) {
                featureItem.remove();
            } else {
                // إذا كانت الميزة الأخيرة، امسح محتواها فقط
                featureItem.querySelector('input[type="text"]').value = '';
            }
        }
    });
});
</script>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control, .btn {
    border-radius: 10px;
}

.input-group > .form-control {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

.input-group > .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.feature-item {
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateX(5px);
}
</style>
@endsection
