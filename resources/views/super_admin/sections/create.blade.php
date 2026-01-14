@extends('layouts.app')

@section('title', 'إضافة قسم')

@section('main-content')
<div class="container">
    <h3 class="mb-3">إضافة قسم</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">المحتوى</label>
                    <textarea name="content" rows="6" class="form-control" required>{{ old('content') }}</textarea>
                    @error('content') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الصورة (اختياري)</label>
                    <input type="file" name="image" class="form-control">
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-primary">حفظ</button>
                    <a href="{{ route('sections.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
