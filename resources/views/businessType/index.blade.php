@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">أنواع النشاط</h1>
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
                            <h3 class="card-title mb-0">قائمة أنواع النشاط</h3>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <form action="{{ route('business-types.index') }}" method="GET" class="d-flex gap-2">
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control form-control-sm"
                                        placeholder="ابحث باسم نوع النشاط"
                                        value="{{ request('name') }}"
                                        style="width: 220px;"
                                    >

                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-search"></i> بحث
                                    </button>

                                    @if(request()->filled('name'))
                                        <a href="{{ route('business-types.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </form>

                                <a href="{{ route('business-types.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> إضافة نوع نشاط
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            {{-- Desktop --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم النوع</th>
                                            <th>Slug</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($businessTypes as $businessType)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $businessType->name }}</td>
                                                <td>{{ $businessType->slug ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $businessType->is_active ? 'success' : 'secondary' }}">
                                                        {{ $businessType->is_active ? 'نشط' : 'متوقف' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('business-types.edit', $businessType->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('business-types.destroy', $businessType->id) }}"
                                                            method="POST"
                                                            class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="button"
                                                                class="btn btn-danger btn-sm delete-btn"
                                                                data-name="{{ $businessType->name }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">لا توجد أنواع نشاط حالياً</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile --}}
                            <div class="d-block d-md-none p-3">
                                @forelse ($businessTypes as $businessType)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">

                                            <div class="d-flex justify-content-between mb-2">
                                                <h5 class="text-primary">{{ $businessType->name }}</h5>

                                                <span class="badge badge-{{ $businessType->is_active ? 'success' : 'secondary' }}">
                                                    {{ $businessType->is_active ? 'نشط' : 'متوقف' }}
                                                </span>
                                            </div>

                                            <div class="text-muted small mb-3">
                                                <div>Slug: {{ $businessType->slug ?? '-' }}</div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-2">
                                                <a href="{{ route('business-types.edit', $businessType->id) }}"
                                                    class="btn btn-info btn-sm flex-grow-1">
                                                    تعديل
                                                </a>

                                                <form action="{{ route('business-types.destroy', $businessType->id) }}"
                                                    method="POST"
                                                    class="flex-grow-1 delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button"
                                                        class="btn btn-danger btn-sm w-100 delete-btn"
                                                        data-name="{{ $businessType->name }}">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info text-center mb-0">
                                        لا توجد أنواع نشاط حالياً
                                    </div>
                                @endforelse
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            {{ $businessTypes->appends(request()->query())->links() }}
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(function (button) {
                button.addEventListener('click', function () {
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
@endsection