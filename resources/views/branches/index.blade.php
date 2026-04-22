@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الفروع</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        {{-- <li class="breadcrumb-item active">الفروع</li> --}}
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
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h3 class="card-title mb-0">قائمة الفروع</h3>

                                <div class="d-flex align-items-center flex-wrap gap-2 ms-auto">
                                    <form method="GET" class="d-flex align-items-center flex-wrap gap-2 mb-0">
                                        <div style="width: 260px;">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="بحث (بالتاريخ / اسم / الهاتف)" value="{{ request('search') }}">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            بحث
                                        </button>
                                    </form>

                                    <a href="{{ route('branches.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> إضافة فرع
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            {{-- Desktop --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الفرع</th>
                                            <th>الكود</th>
                                            <th>الهاتف</th>
                                            <th>المستخدمين</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($branches as $branch)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $branch->name }}</td>
                                                <td>{{ $branch->code ?? '-' }}</td>
                                                <td>{{ $branch->phone ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ $branch->users_count }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge badge-{{ $branch->is_active ? 'success' : 'secondary' }}">
                                                        {{ $branch->is_active ? 'نشط' : 'متوقف' }}
                                                    </span>
                                                </td>

                                                <td>{{ $branch->created_at->format('Y-m-d') }}</td>

                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('branches.edit', $branch->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('branches.destroy', $branch->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('هل أنت متأكد؟')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile --}}
                            <div class="d-block d-md-none p-3">
                                @foreach ($branches as $branch)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">

                                            <div class="d-flex justify-content-between mb-2">
                                                <h5 class="text-primary">{{ $branch->name }}</h5>

                                                <span
                                                    class="badge badge-{{ $branch->is_active ? 'success' : 'secondary' }}">
                                                    {{ $branch->is_active ? 'نشط' : 'متوقف' }}
                                                </span>
                                            </div>

                                            <div class="text-muted small mb-3">
                                                <div>كود: {{ $branch->code ?? '-' }}</div>
                                                <div>هاتف: {{ $branch->phone ?? '-' }}</div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-2">
                                                <a href="{{ route('branches.edit', $branch->id) }}"
                                                    class="btn btn-info btn-sm flex-grow-1">
                                                    تعديل
                                                </a>

                                                <form action="{{ route('branches.destroy', $branch->id) }}" method="POST"
                                                    class="flex-grow-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100"
                                                        onclick="return confirm('هل أنت متأكد؟')">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            {{ $branches->links() }}
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


@endsection
