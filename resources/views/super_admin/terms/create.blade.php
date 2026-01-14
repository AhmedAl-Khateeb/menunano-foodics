@extends('layouts.app')

@section('title', 'إضافة شرط جديد')

@section('main-content')
<div class="container mt-4">
    <h3>إضافة شرط جديد</h3>
    <form action="{{ route('terms.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>العنوان</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>النص</label>
            <textarea name="content" rows="5" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="{{ route('terms.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
