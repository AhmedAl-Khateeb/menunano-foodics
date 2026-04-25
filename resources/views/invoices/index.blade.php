@extends('layouts.app')

@section('main-content')
<div class="container my-4" dir="rtl">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">الفواتير</h3>
            <p class="text-muted mb-0">كل فواتير نقاط البيع</p>
        </div>

        <a href="{{ route('pos.index') }}" class="btn btn-primary">
            العودة لنقاط البيع
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>النوع</th>
                        <th>الدفع</th>
                        <th>الإجمالي</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ optional($order->customer)->name ?? $order->name ?? 'عام' }}</td>
                            <td>{{ $order->type }}</td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                            <td>{{ number_format($order->total_price, 2) }} ج.م</td>
                            <td>
                                @if($order->status === 'served')
                                    <span class="badge badge-success">مدفوعة</span>
                                @else
                                    <span class="badge badge-warning">معلقة</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                            <td>
                                <a href="{{ route('invoices.print', $order->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-dark">
                                    طباعة
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted py-4">لا توجد فواتير</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection