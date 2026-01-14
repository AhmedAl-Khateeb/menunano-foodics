@extends('layouts.app')

@section('title', 'تعديل الشرط')

@section('main-content')
<div class="container mt-4">
    <h3>تعديل الشرط</h3>
    <form action="{{ route('terms.update', $term->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ $term->title }}" required>
        </div>

        <div class="mb-3">
            <label>النص</label>
            <textarea name="content" rows="5" class="form-control" required>{{ $term->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">تحديث</button>
        <a href="{{ route('terms.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
