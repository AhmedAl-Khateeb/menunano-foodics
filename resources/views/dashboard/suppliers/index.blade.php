@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الموردون</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                    </ol> --}}
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h3 class="card-title mb-0">قائمة الموردين</h3>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form action="{{ route('inventory.suppliers.index') }}" method="GET"
                            class="d-flex flex-wrap gap-2">
                            <input type="text" name="search" class="form-control form-control-sm" style="width: 240px;"
                                value="{{ request('search') }}" placeholder="بحث بالاسم \ الهاتف \ التاريخ">

                            <select name="status" class="form-control form-control-sm" style="width: 160px;">
                                <option value="">كل الحالات</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>موقوف
                                </option>
                            </select>

                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-search"></i> بحث
                            </button>

                            <a href="{{ route('inventory.suppliers.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>

                        <a href="{{ route('inventory.suppliers.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة مورد
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المورد</th>
                                    <th>الكود</th>
                                    <th>الهاتف</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->code ?: '-' }}</td>
                                        <td>{{ $supplier->phone ?: '-' }}</td>
                                        <td>{{ $supplier->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('inventory.suppliers.show', $supplier->id) }}"
                                                    class="btn btn-info btn-sm" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('inventory.suppliers.edit', $supplier->id) }}"
                                                    class="btn btn-primary btn-sm" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('inventory.suppliers.destroy', $supplier->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-name="{{ $supplier->name }}">
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

                    <div class="d-block d-md-none p-3">
                        @forelse ($suppliers as $supplier)
                            <div class="card mb-3 border shadow-none rounded-lg">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="text-primary mb-0">{{ $supplier->name }}</h5>
                                        <span class="badge badge-{{ $supplier->is_active ? 'success' : 'secondary' }}">
                                            {{ $supplier->is_active ? 'نشط' : 'موقوف' }}
                                        </span>
                                    </div>

                                    <div class="text-muted small mb-3">
                                        <div>اسم الاتصال: {{ $supplier->contact_name ?: '-' }}</div>
                                        <div>الكود: {{ $supplier->code ?: '-' }}</div>
                                        <div>الهاتف: {{ $supplier->phone ?: '-' }}</div>
                                        <div>البريد: {{ $supplier->email ?: '-' }}</div>
                                    </div>

                                    <div class="d-flex gap-2 border-top pt-2">
                                        <a href="{{ route('inventory.suppliers.show', $supplier->id) }}"
                                            class="btn btn-info btn-sm flex-grow-1">
                                            عرض
                                        </a>

                                        <a href="{{ route('inventory.suppliers.edit', $supplier->id) }}"
                                            class="btn btn-primary btn-sm flex-grow-1">
                                            تعديل
                                        </a>

                                        <form action="{{ route('inventory.suppliers.destroy', $supplier->id) }}"
                                            method="POST" class="flex-grow-1 delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-danger btn-sm w-100 delete-btn"
                                                data-name="{{ $supplier->name }}">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center mb-0">
                                لا توجد بيانات حالياً
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $suppliers->links() }}
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
                    const name = this.dataset.name || 'هذا المورد';

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
