@extends('layouts.app')
@section('main-content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>وسائل الدفع</h3>
        <a href="{{ route('payment-methods.create') }}" class="btn btn-success">+ إضافة وسيلة</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0 table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الوصف</th>
                        <th>الهاتف</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($methods as $i => $m)
                        <tr class="text-center">
                            <td>{{ $methods->firstItem() + $i }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->description }}</td>
                            <td>{{ $m->phone }}</td>
                            <td>
                                <form action="{{ route('payment-methods.toggle', $m->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')

                                    @if($m->is_active)
                                        <span class="badge bg-success">مفعّل</span>
                                        <button class="btn btn-sm btn-outline-warning ms-2" title="تعطيل">
                                            <i class="fas fa-toggle-off"></i>
                                        </button>
                                    @else
                                        <span class="badge bg-secondary">معطّل</span>
                                        <button class="btn btn-sm btn-outline-success ms-2" title="تفعيل">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-outline-primary btn-sm"
                                       href="{{ route('payment-methods.edit', $m->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('payment-methods.destroy', $m->id) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('حذف؟');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center p-4">لا توجد وسائل دفع</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $methods->links() }}
    </div>
</div>
@endsection
