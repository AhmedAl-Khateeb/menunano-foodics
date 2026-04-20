@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">جرد المخزن</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h3 class="card-title mb-0">جلسات الجرد</h3>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form action="{{ route('inventory.stock-counts.index') }}" method="GET"
                            class="d-flex flex-wrap gap-2">
                            <input type="text" name="search" class="form-control form-control-sm" style="width:180px;"
                                value="{{ request('search') }}" placeholder="بحث برقم الجلسة">

                            <select name="type" class="form-control form-control-sm" style="width:150px;">
                                <option value="">كل الأنواع</option>
                                <option value="full" {{ request('type') == 'full' ? 'selected' : '' }}>جرد كامل</option>
                                <option value="spot" {{ request('type') == 'spot' ? 'selected' : '' }}>جرد جزئي</option>
                            </select>

                            <select name="status" class="form-control form-control-sm" style="width:150px;">
                                <option value="">كل الحالات</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>معتمد
                                </option>
                            </select>

                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-search"></i> بحث
                            </button>

                            <a href="{{ route('inventory.stock-counts.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>

                        <a href="{{ route('inventory.stock-counts.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة جلسة جرد
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الجلسة</th>
                                    <th>التاريخ</th>
                                    <th>النوع</th>
                                    <th>عدد الأصناف</th>
                                    <th>الحالة</th>
                                    <th>المعتمد بواسطة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockCounts as $count)
                                    <tr>
                                        <td>{{ $stockCounts->firstItem() + $loop->index }}</td>
                                        <td>{{ $count->count_number }}</td>
                                        <td>{{ $count->count_date?->format('Y-m-d') }}</td>
                                        <td>{{ $count->type === 'full' ? 'جرد كامل' : 'جرد جزئي' }}</td>
                                        <td>{{ $count->items->count() }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $count->status === 'approved' ? 'success' : 'secondary' }}">
                                                {{ $count->status === 'approved' ? 'معتمد' : 'مسودة' }}
                                            </span>
                                        </td>
                                        <td>{{ $count->approver->name ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                                @if ($count->status !== 'approved')
                                                    <form
                                                        action="{{ route('inventory.stock-counts.approve', $count->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('inventory.stock-counts.edit', $count->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('inventory.stock-counts.destroy', $count->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-name="{{ $count->count_number }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">لا توجد بيانات حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $stockCounts->links() }}
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
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: @json(session('success')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: @json(session('error')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    const name = this.dataset.name || 'هذه الجلسة';
                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: `سيتم حذف "${name}" نهائيًا`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، احذف',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
@endsection
