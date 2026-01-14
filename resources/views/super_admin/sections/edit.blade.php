@extends('layouts.app')

@section('title', 'تعديل قسم')

@section('main-content')
<div class="container">
    <h3 class="mb-3">تعديل قسم</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sections.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $section->title) }}" required>
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">المحتوى</label>
                    <textarea name="content" rows="6" class="form-control" required>{{ old('content', $section->content) }}</textarea>
                    @error('content') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">الصورة الحالية</label>
                    @if($section->image)
                        <img src="{{ asset('storage/'.$section->image) }}" alt="" width="120" class="mb-2">
                    @else
                        —
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">تحديث الصورة (اختياري)</label>
                    <input type="file" name="image" class="form-control">
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-primary">تحديث</button>
                    <a href="{{ route('sections.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
