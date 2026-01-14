@extends('layouts.app')

@section('title', 'إضافة مدير جديد')

@section('main-content')
<div class="container mt-4">
    <h3>إضافة مدير جديد</h3>

    {{-- عرض الأخطاء --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>اسم المتجر</label>
            <input type="text" name="store_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>الهاتف</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>الصورة</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control" required>
                <option value="1">مفعل</option>
                <option value="0">غير مفعل</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="{{ route('admins.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
