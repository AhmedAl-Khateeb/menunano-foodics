@extends('layouts.app')

@section('title', 'تعديل المدير')

@section('main-content')
<div class="container mt-4">
    <h3>تعديل المدير</h3>
    <form action="{{ route('admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>اسم المتجر</label>
            <input type="text" name="store_name" class="form-control" value="{{ $admin->store_name }}">
        </div>

        <div class="mb-3">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
        </div>

        <div class="mb-3">
            <label>كلمة المرور (اتركه فارغ إذا لا تريد التغيير)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>الهاتف</label>
            <input type="text" name="phone" class="form-control" value="{{ $admin->phone }}">
        </div>

        <div class="mb-3">
            <label>الصورة</label><br>
            @if($admin->image)
                <img src="{{ asset('storage/app/public/'.$admin->image) }}" width="80" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label>الباقة</label>
            <select name="package_id" class="form-control" >
                <option value="">-- اختر الباقة --</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}"
                        {{ $admin->package_id == $package->id ? 'selected' : '' }}>
                        {{ $package->name }} ({{ $package->duration }} يوم{{ $package->duration > 1 ? '' : '' }})
                    </option>
                @endforeach
            </select>
        </div>

<div class="form-group">
    <label for="subscription_start">تاريخ بدء الاشتراك</label>
    <input type="date" name="subscription_start" id="subscription_start"
           class="form-control"
           value="{{ old('subscription_start', $admin->subscription_start ? $admin->subscription_start->format('Y-m-d') : '') }}">
</div>

@if($admin->subscription_end)
    <p class="mt-2 text-success">
        تاريخ انتهاء الاشتراك: {{ $admin->subscription_end->format('Y-m-d') }}
    </p>
@endif

        <div class="mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control">
                <option value="1" {{ $admin->status == 1 ? 'selected' : '' }}>نشط</option>
                <option value="0" {{ $admin->status == 0 ? 'selected' : '' }}>موقوف</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('admins.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
