@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">أوامر الشراء</h1>
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
                    <h3 class="card-title mb-0">قائمة أمر الشراء</h3>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form action="{{ route('inventory.purchase-orders.index') }}" method="GET"
                            class="d-flex flex-wrap gap-2">
                            <input type="text" name="search" class="form-control form-control-sm" style="width:180px;"
                                value="{{ request('search') }}" placeholder="بحث بالرقم أو المورد">

                            <select name="supplier_id" class="form-control form-control-sm" style="width:180px;">
                                <option value="">كل الموردين</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="status" class="form-control form-control-sm" style="width:160px;">
                                <option value="">كل الحالات</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>معتمد
                                </option>
                                <option value="partial_received"
                                    {{ request('status') == 'partial_received' ? 'selected' : '' }}>استلام جزئي</option>
                                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>مستلم
                                </option>
                            </select>

                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-search"></i> بحث
                            </button>

                            <a href="{{ route('inventory.purchase-requests.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>

                        <a href="{{ route('inventory.purchase-orders.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة أمر شراء
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الأمر</th>
                                    <th>المورد</th>
                                    <th>التاريخ</th>
                                    <th>التوريد المتوقع</th>
                                    <th>الإجمالي</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchaseOrders as $order)
                                    <tr>
                                        <td>{{ $purchaseOrders->firstItem() + $loop->index }}</td>
                                        <td>{{ $order->po_number }}</td>
                                        <td>{{ $order->supplier->name ?? '-' }}</td>
                                        <td>{{ $order->po_date?->format('Y-m-d') }}</td>
                                        <td>{{ $order->expected_date?->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ rtrim(rtrim(number_format($order->total ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'draft' => ['secondary', 'مسودة'],
                                                    'approved' => ['primary', 'معتمد'],
                                                    'partial_received' => ['warning', 'استلام جزئي'],
                                                    'received' => ['success', 'مستلم'],
                                                    'cancelled' => ['danger', 'ملغي'],
                                                ];
                                                $statusData = $statusMap[$order->status] ?? [
                                                    'secondary',
                                                    $order->status,
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $statusData[0] }}">{{ $statusData[1] }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                                @if ($order->status === 'draft')
                                                    <form
                                                        action="{{ route('inventory.purchase-orders.approve', $order->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            title="اعتماد">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('inventory.purchase-orders.edit', $order->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('inventory.purchase-orders.destroy', $order->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-name="{{ $order->po_number }}">
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
                        @forelse($purchaseOrders as $order)
                            <div class="card mb-3 border shadow-none rounded-lg">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="text-primary">{{ $order->po_number }}</h5>
                                        <span class="badge badge-{{ $statusData[0] ?? 'secondary' }}">
                                            {{ $statusMap[$order->status][1] ?? $order->status }}
                                        </span>
                                    </div>

                                    <div class="text-muted small mb-3">
                                        <div>المورد: {{ $order->supplier->name ?? '-' }}</div>
                                        <div>التاريخ: {{ $order->po_date?->format('Y-m-d') }}</div>
                                        <div>التوريد المتوقع: {{ $order->expected_date?->format('Y-m-d') ?? '-' }}</div>
                                        <div>الإجمالي: {{ number_format($order->total ?? 0, 3) }}</div>
                                    </div>

                                    <div class="d-flex gap-2 border-top pt-2 flex-wrap">
                                        @if ($order->status === 'draft')
                                            <form action="{{ route('inventory.purchase-orders.approve', $order->id) }}"
                                                method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm w-100">اعتماد</button>
                                            </form>
                                        @endif

                                        <a href="{{ route('inventory.purchase-orders.edit', $order->id) }}"
                                            class="btn btn-info btn-sm flex-grow-1">
                                            تعديل
                                        </a>

                                        <form action="{{ route('inventory.purchase-orders.destroy', $order->id) }}"
                                            method="POST" class="flex-grow-1 delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm w-100 delete-btn"
                                                data-name="{{ $order->po_number }}">
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
                    {{ $purchaseOrders->links() }}
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
                    const name = this.dataset.name || 'هذا الأمر';

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
