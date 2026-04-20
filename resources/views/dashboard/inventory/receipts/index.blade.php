@extends('layouts.app')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">الشراء / الاستلام</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">سندات الاستلام</h3>
                <a href="{{ route('inventory.receipts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> إضافة استلام
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم السند</th>
                                <th>المورد</th>
                                <th>أمر الشراء</th>
                                <th>التاريخ</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receipts as $receipt)
                                <tr>
                                    <td>{{ $receipts->firstItem() + $loop->index }}</td>
                                    <td>{{ $receipt->receipt_number }}</td>
                                    <td>{{ $receipt->supplier->name ?? '-' }}</td>
                                    <td>{{ $receipt->purchaseOrder->po_number ?? '-' }}</td>
                                    <td>{{ $receipt->receipt_date?->format('Y-m-d') }}</td>
                                    <td>{{ number_format($receipt->total ?? 0, 3) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $receipt->status === 'posted' ? 'success' : 'secondary' }}">
                                            {{ $receipt->status === 'posted' ? 'مرحّل' : 'مسودة' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($receipt->status === 'draft')
                                            <form action="{{ route('inventory.receipts.post', $receipt->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> ترحيل
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-success">تم الترحيل</span>
                                        @endif
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
                {{ $receipts->links() }}
            </div>
        </div>
    </div>
</section>
@endsection