@extends('layouts.app')

@section('title', 'الشروط والأحكام')

@section('main-content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>الشروط والأحكام</h3>
        <a href="{{ route('terms.create') }}" class="btn btn-success">إضافة جديد</a>
    </div>

    @forelse($terms as $term)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $term->title }}</h5>
                <p class="card-text">{{ Str::limit($term->content, 200) }}</p>

                <div class="d-flex gap-2">
                    <a href="{{ route('terms.edit', $term->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                    <form action="{{ route('terms.destroy', $term->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">لا توجد شروط وأحكام بعد</div>
    @endforelse
</div>
 <div class="col-sm-6">
        <ol class="float-sm-right mb-0 p-0" style="list-style: none;">
            <li>
                <a href="{{ route('dashboard') }}" class="btn btn-success"
                    style="color: #fff; transition: all 0.2s ease-in-out;"
                    onmouseover="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff'; this.style.color='#fff';"
                    onmouseout="this.style.backgroundColor=''; this.style.borderColor=''; this.style.color='#fff';">
                    الرئيسية
                </a>
            </li>
        </ol>
    </div>
@endsection
