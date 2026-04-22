@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الحضور والانصراف</h1>
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
                            <h3 class="card-title mb-0">قائمة الحضور والانصراف</h3>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <form action="{{ route('attendances.index') }}" method="GET"
                                    class="d-flex flex-wrap gap-2">
                                    <select name="user_id" class="form-control form-control-sm" style="width: 180px;">
                                        <option value="">كل الموظفين</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="date" name="created_at" class="form-control form-control-sm"
                                        value="{{ request('created_at') }}" style="width: 180px;">

                                    <select name="status" class="form-control form-control-sm" style="width: 160px;">
                                        <option value="">كل الحالات</option>
                                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>حاضر
                                        </option>
                                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>غائب
                                        </option>
                                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>متأخر
                                        </option>
                                        <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>إجازة
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-search"></i> بحث
                                    </button>

                                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </form>

                                <a href="{{ route('attendances.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> إضافة سجل
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
                                            <th>التاريخ</th>
                                            <th>الحضور</th>
                                            <th>الانصراف</th>
                                            <th>الحالة</th>
                                            <th>الشيفت</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($attendances as $attendance)
                                            <tr>
                                                <td>{{ $attendances->firstItem() + $loop->index }}</td>
                                                <td>{{ $attendance->user->name ?? '-' }}</td>
                                                <td>{{ $attendance->created_at?->format('Y-m-d') }}</td>
                                                <td>{{ $attendance->check_in ? $attendance->check_in->format('Y-m-d h:i A') : '-' }}
                                                </td>
                                                <td>{{ $attendance->check_out ? $attendance->check_out->format('Y-m-d h:i A') : '-' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $labels = [
                                                            'present' => ['success', 'حاضر'],
                                                            'absent' => ['danger', 'غائب'],
                                                            'late' => ['warning', 'متأخر'],
                                                            'leave' => ['secondary', 'إجازة'],
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $labels[$attendance->status][0] ?? 'secondary' }}">
                                                        {{ $labels[$attendance->status][1] ?? $attendance->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($attendance->shift)
                                                        {{ $attendance->shift->user->name ?? '' }} <br>
                                                        <small>
                                                            {{ $attendance->shift->start_time?->format('Y-m-d h:i A') }}
                                                        </small>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('attendances.edit', $attendance->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                            method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                data-name="{{ $attendance->user->name ?? 'هذا السجل' }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">لا توجد سجلات حالياً</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-block d-md-none p-3">
                                @forelse ($attendances as $attendance)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h5 class="text-primary">{{ $attendance->user->name ?? '-' }}</h5>
                                                <span
                                                    class="badge badge-primary">{{ $attendance->attendance_date?->format('Y-m-d') }}</span>
                                            </div>

                                            <div class="text-muted small mb-3">
                                                <div>الحضور:
                                                    {{ $attendance->check_in ? $attendance->check_in->format('Y-m-d h:i A') : '-' }}
                                                </div>
                                                <div>الانصراف:
                                                    {{ $attendance->check_out ? $attendance->check_out->format('Y-m-d h:i A') : '-' }}
                                                </div>
                                                <div>الحالة: {{ $labels[$attendance->status][1] ?? $attendance->status }}
                                                </div>
                                                <div>الشيفت: #{{ $attendance->shift_id ?? '-' }}</div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-2">
                                                <a href="{{ route('attendances.edit', $attendance->id) }}"
                                                    class="btn btn-info btn-sm flex-grow-1">
                                                    تعديل
                                                </a>

                                                <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                    method="POST" class="flex-grow-1 delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn btn-danger btn-sm w-100 delete-btn"
                                                        data-name="{{ $attendance->user->name ?? 'هذا السجل' }}">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info text-center mb-0">
                                        لا توجد سجلات حالياً
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer clearfix">
                            {{ $attendances->links() }}
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
                    const name = this.dataset.name || 'هذا السجل';

                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: `سيتم حذف سجل "${name}" نهائيًا`,
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
@endsection
