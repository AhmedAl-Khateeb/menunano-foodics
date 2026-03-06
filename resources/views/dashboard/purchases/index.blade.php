@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">فواتير المشتريات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">المشتريات</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                            <h3 class="card-title font-weight-bold text-dark">سجل الفواتير</h3>
                            <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm ms-auto shadow-sm">
                                <i class="fas fa-plus mr-1"></i> فاتورة جديدة
                            </a>
                        </div>
                        <div class="card-body p-0 mt-3">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th class="border-top-0 pl-4">#</th>
                                            <th class="border-top-0">رقم الفاتورة</th>
                                            <th class="border-top-0">المورد</th>
                                            <th class="border-top-0 text-center">التاريخ</th>
                                            <th class="border-top-0 text-center">الإجمالي</th>
                                            <th class="border-top-0 text-center">المدفوع</th>
                                            <th class="border-top-0 text-center">الحالة</th>
                                            <th class="border-top-0 text-center">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices as $invoice)
                                            <tr>
                                                <td class="pl-4 text-muted">{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold text-primary">{{ $invoice->invoice_number ?? '-' }}</td>
                                                <td class="font-weight-bold text-dark">{{ optional($invoice->supplier)->name ?? 'مورد محذوف' }}</td>
                                                <td class="text-center text-muted" dir="ltr">{{ $invoice->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center font-weight-bold">{{ number_format($invoice->total_amount, 2) }} ج.م</td>
                                                <td class="text-center text-success">{{ number_format($invoice->paid_amount, 2) }} ج.م</td>
                                                <td class="text-center">
                                                    @if($invoice->status == 'paid')
                                                        <span class="badge badge-success px-2 py-1 shadow-sm">مدفوعة بالكامل</span>
                                                    @elseif($invoice->status == 'partial')
                                                        <span class="badge badge-warning px-2 py-1 shadow-sm">مدفوعة جزئياً</span>
                                                    @else
                                                        <span class="badge badge-danger px-2 py-1 shadow-sm">غير مدفوعة</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('purchases.show', $invoice->id) }}" class="btn btn-light btn-sm text-info shadow-sm hover-bg-info" title="عرض الفاتورة">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('purchases.destroy', $invoice->id) }}" method="POST" style="display:inline-block;" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-light btn-sm text-danger shadow-sm hover-bg-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الفاتورة والتراجع عن الحركات المخزنية؟')" title="حذف الفاتورة">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-5">
                                                    <i class="fas fa-file-invoice-dollar text-light block mb-3" style="font-size: 3rem;"></i><br>
                                                    لا توجد فواتير مشتريات مسجلة
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hover-bg-info:hover { background-color: #17a2b8 !important; color: white !important; }
        .hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; }
    </style>
@endsection
