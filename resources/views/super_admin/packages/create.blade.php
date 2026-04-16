@extends('layouts.app')

@section('main-content')
    <div class="container">
        <h2>إضافة باقة جديدة</h2>
        <form action="{{ route('packages.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>اسم الباقة</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>السعر</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>المدة (بالأيام)</label>
                <input type="number" name="duration" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>نوع النشاط</label>
                <select name="business_type_id" class="form-control" required>
                    <option value="">اختر نوع النشاط</option>
                    @foreach ($businessTypes as $businessType)
                        <option value="{{ $businessType->id }}"
                            {{ old('business_type_id') == $businessType->id ? 'selected' : '' }}>
                            {{ $businessType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- المميزات --}}
            <div class="mb-3">
                <label>المميزات</label>
                <div id="features-wrapper">
                    <div class="input-group mb-2">
                        <input type="text" name="features[]" class="form-control" placeholder="أدخل ميزة">
                        <button type="button" class="btn btn-danger remove-feature">حذف</button>
                    </div>
                </div>
                <button type="button" id="add-feature" class="btn btn-secondary">+ إضافة ميزة</button>
            </div>

            <div class="mb-3">
                <label>مفعل</label>
                <input type="checkbox" name="is_active" value="1" checked>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>

    {{-- JS لإضافة/حذف المميزات --}}
    <script>
        document.getElementById('add-feature').addEventListener('click', function() {
            let wrapper = document.getElementById('features-wrapper');
            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
            <input type="text" name="features[]" class="form-control" placeholder="أدخل ميزة">
            <button type="button" class="btn btn-danger remove-feature">حذف</button>
        `;
            wrapper.appendChild(div);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-feature')) {
                e.target.parentElement.remove();
            }
        });
    </script>
@endsection
