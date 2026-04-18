@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الشيفتات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h3 class="card-title mb-0">قائمة الشيفتات</h3>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <form action="{{ route('shifts.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                                    <select name="user_id" class="form-control form-control-sm" style="width: 180px;">
                                        <option value="">كل الموظفين</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="branch_id" class="form-control form-control-sm" style="width: 180px;">
                                        <option value="">كل الفروع</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="status" class="form-control form-control-sm" style="width: 160px;">
                                        <option value="">كل الحالات</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط
                                        </option>
                                        <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>موقوف
                                        </option>
                                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلق
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-search"></i> بحث
                                    </button>

                                    <a href="{{ route('shifts.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </form>

                                <a href="{{ route('shifts.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> إضافة شيفت
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الموظف</th>
                                            <th>المتجر</th>
                                            <th>بداية الشيفت</th>
                                            <th>نهاية الشيفت</th>
                                            <th>رصيد البداية</th>
                                            <th>رصيد النهاية</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($shifts as $shift)
                                            <tr>
                                                <td>{{ $shifts->firstItem() + $loop->index }}</td>
                                                <td>{{ $shift->user->name ?? '-' }}</td>
                                                <td>{{ $shift->branch->name ?? '-' }}</td>
                                                <td>{{ $shift->start_time ? $shift->start_time->format('Y-m-d h:i A') : '-' }}
                                                </td>
                                                <td>{{ $shift->end_time ? $shift->end_time->format('Y-m-d h:i A') : '-' }}
                                                </td>
                                                <td>{{ number_format((float) $shift->starting_cash, 2) }}</td>
                                                <td>{{ $shift->ending_cash !== null ? number_format((float) $shift->ending_cash, 2) : '-' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $labels = [
                                                            'active' => ['success', 'نشط'],
                                                            'paused' => ['warning', 'موقوف'],
                                                            'closed' => ['secondary', 'مغلق'],
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $labels[$shift->status][0] ?? 'secondary' }}">
                                                        {{ $labels[$shift->status][1] ?? $shift->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        @if ($shift->status !== 'closed')
                                                            <form action="{{ route('shifts.close', $shift->id) }}"
                                                                method="POST" class="d-inline close-form">
                                                                @csrf
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm close-btn"
                                                                    title="اغلاق الشيفت"
                                                                    data-name="شيفت #{{ $shift->id }}">
                                                                    <i class="fas fa-lock"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('shifts.edit', $shift->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('shifts.destroy', $shift->id) }}"
                                                            method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                data-name="شيفت #{{ $shift->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">لا توجد شيفتات حالياً</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-block d-md-none p-3">
                                @forelse ($shifts as $shift)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h5 class="text-primary">{{ $shift->user->name ?? '-' }}</h5>
                                                <span class="badge badge-{{ $labels[$shift->status][0] ?? 'secondary' }}">
                                                    {{ $labels[$shift->status][1] ?? $shift->status }}
                                                </span>
                                            </div>

                                            <div class="text-muted small mb-3">
                                                <div>المتجر: {{ $shift->store->name ?? '-' }}</div>
                                                <div>البداية:
                                                    {{ $shift->start_time ? $shift->start_time->format('Y-m-d h:i A') : '-' }}
                                                </div>
                                                <div>النهاية:
                                                    {{ $shift->end_time ? $shift->end_time->format('Y-m-d h:i A') : '-' }}
                                                </div>
                                                <div>رصيد البداية: {{ number_format((float) $shift->starting_cash, 2) }}
                                                </div>
                                                <div>رصيد النهاية:
                                                    {{ $shift->ending_cash !== null ? number_format((float) $shift->ending_cash, 2) : '-' }}
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-2">
                                                <a href="{{ route('shifts.edit', $shift->id) }}"
                                                    class="btn btn-info btn-sm flex-grow-1">
                                                    تعديل
                                                </a>

                                                <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST"
                                                    class="flex-grow-1 delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn btn-danger btn-sm w-100 delete-btn"
                                                        data-name="شيفت #{{ $shift->id }}">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info text-center mb-0">
                                        لا توجد شيفتات حالياً
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer clearfix">
                            {{ $shifts->appends(request()->query())->links() }}
                        </div>
                    </div>

                </div>
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
                    const name = this.dataset.name || 'هذا العنصر';

                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: `سيتم حذف "${name}" نهائيًا`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، احذف',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.close-btn').forEach(function (button) {
            button.addEventListener('click', function () {

                const form = this.closest('.close-form');
                const name = this.dataset.name || 'هذا الشيفت';

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: `سيتم إغلاق "${name}"`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، اغلاق',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });
        });

    });
</script>
@endsection
