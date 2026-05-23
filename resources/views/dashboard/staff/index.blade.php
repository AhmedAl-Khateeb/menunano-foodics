@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                                <h3 class="card-title mb-0">سجل الموظفين</h3>

                                <div class="d-flex align-items-center flex-wrap gap-2 ms-auto">

                                    {{-- Search (اختياري لو عندك فلترة) --}}
                                    <form method="GET" class="d-flex align-items-center flex-wrap mb-0" style="gap: 8px;">

                                        {{-- <div style="width: 240px;">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="بحث بالاسم / الموبايل" value="{{ request('search') }}">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            بحث
                                        </button> --}}

                                        {{-- <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a> --}}

                                    </form>

                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createStaff">
                                        <i class="fas fa-plus"></i>
                                        موظف جديد
                                    </button>

                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover align-middle">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الموظف</th>
                                            <th>الموبايل</th>
                                            <th>أيام العمل</th>
                                            <th>ساعات العمل</th>
                                            <th>تاريخ التعيين</th>
                                            <th>تاريخ الاستقالة</th>
                                            <th>المرتب</th>
                                            <th class="text-center">الإجراءات</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($staffs as $staff)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $staff->Name }}</td>

                                                <td>
                                                    <span class="badge badge-light border">
                                                        {{ $staff->mobile }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ $staff->Number_of_days }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-primary">
                                                        {{ $staff->Number_of_hours }}
                                                    </span>
                                                </td>

                                                <td>{{ $staff->Start_date ?? '-' }}</td>
                                                <td>{{ $staff->End_date ?? '-' }}</td>

                                                <td>
                                                    <span class="badge badge-success">
                                                        {{ number_format($staff->Salary, 2) }} ج.م
                                                    </span>
                                                </td>

                                                <td class="text-center">

                                                    <div class="d-flex justify-content-center gap-1">

                                                        <a href="{{ route('salary_m.index') }}?staff_id={{ $staff->id }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                        </a>

                                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#editStaff{{ $staff->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <form action="{{ route('staff.destroy', $staff->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="return confirm('هل أنت متأكد؟')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>

                                                    </div>

                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-5 text-muted">
                                                    لا توجد بيانات
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    {{-- Edit Staff Modals --}}
                                    @foreach ($staffs as $staff)
                                        <div class="modal fade" id="editStaff{{ $staff->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">

                                                    <form method="POST" action="{{ route('staff.update', $staff->id) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div
                                                            class="modal-header d-flex justify-content-between align-items-center border-bottom px-4">

                                                            <h5 class="modal-title font-weight-bold mb-0">
                                                                تعديل موظف
                                                            </h5>

                                                            <button type="button"
                                                                class="btn btn-sm btn-light border text-danger"
                                                                data-dismiss="modal">
                                                                &times;
                                                            </button>

                                                        </div>

                                                        <div class="modal-body">
                                                            @include('dashboard.staff.form', [
                                                                'staff' => $staff,
                                                            ])
                                                        </div>

                                                        <div class="modal-footer d-flex justify-content-between">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">تحديث</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            {{ $staffs->links() }}
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
            </div>
        </div>
        </div>
    </section>

    {{-- create --}}
    <div class="modal fade" id="createStaff">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form method="POST" action="{{ route('staff.store') }}">
                    @csrf


                    <div class="modal-header d-flex justify-content-between align-items-center border-bottom px-4">
                        <h5 class="modal-title font-weight-bold mb-0">
                            إضافة موظف
                        </h5>
                        <button type="button" class="btn btn-sm btn-light border text-danger" data-dismiss="modal">
                            &times;
                        </button>

                    </div>

                    <div class="modal-body">
                        @include('dashboard.staff.form', ['staff' => null])
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </form>

            </div>
        </div>
    </div>



    <style>
        .hover-bg-info:hover {
            background-color: #17a2b8 !important;
            color: white !important;
        }

        .hover-bg-danger:hover {
            background-color: #dc3545 !important;
            color: white !important;
        }
    </style>

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
@endsection
