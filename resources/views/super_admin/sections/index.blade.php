@extends('layouts.app')

@section('title', 'إدارة الأقسام')

@section('main-content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>الأقسام</h3>
            <a href="{{ route('sections.create') }}" class="btn btn-success">+ إضافة قسم</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0 table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>العنوان</th>
                            <th>الصورة</th>
                            <th>أنشئ في</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $i => $s)
                            <tr class="text-center">
                                <td>{{ $sections->firstItem() + $i }}</td>
                                <td>{{ $s->title }}</td>
                                <td>
                                    @if ($s->image)
                                        <img src="{{ asset('storage/app/public/' . $s->image) }}" alt="image"
                                            width="80">
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $s->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('sections.edit', $s->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sections.destroy', $s->id) }}" method="POST"
                                            onsubmit="return confirm('حذف هذا القسم؟');" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-4">لا توجد أقسام</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $sections->links() }}
        </div>
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
