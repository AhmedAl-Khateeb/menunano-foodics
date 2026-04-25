@extends('layouts.app')

@section('main-content')
    <div class="container-fluid my-4" dir="rtl">

        @php
            $labels = [
                'active' => ['success', 'نشط'],
                'paused' => ['warning', 'موقوف'],
                'closed' => ['secondary', 'مغلق'],
            ];
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">تفاصيل الشيفت #{{ $shift->id }}</h3>
                <p class="text-muted mb-0">
                    الموظف: {{ $shift->user->name ?? '-' }}
                </p>
            </div>

            <a href="{{ route('shifts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i>
                رجوع للشيفتات
            </a>
        </div>

        <div class="row mb-4">

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted mb-1 text-right">الموظف</div>
                        <h5 class="mb-0 text-center">{{ $shift->user->name ?? '-' }}</h5>
                        <h6 class="text-muted text-center">ID: {{ $shift->user_id }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted mb-1 text-right">الفرع</div>
                        <h5 class="mb-0 text-center">{{ $shift->branch->name ?? '-' }}</h5>
                        <h6 class="text-muted text-center">Branch ID: {{ $shift->branch_id ?? '-' }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-muted mb-1 text-right">حالة الشيفت</div>
                        <span class="badge badge-{{ $labels[$shift->status][0] ?? 'secondary' }} p-2  text-center">
                            {{ $labels[$shift->status][1] ?? $shift->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-muted mb-1 text-right">مغلق بواسطة</div>
                        <h5 class="mb-0">{{ $shift->closedBy->name ?? '-' }}</h5>
                        <small class="text-muted">ID: {{ $shift->closed_by ?? '-' }}</small>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-4">

            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white text-right">
                        بيانات هذا الشيفت
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-bordered text-center mb-0">
                            <tr>
                                <th>رقم الشيفت</th>
                                <td>#{{ $shift->id }}</td>
                            </tr>

                            <tr>
                                <th>بداية الشيفت</th>
                                <td>{{ $shift->start_time ? $shift->start_time->format('Y-m-d h:i A') : '-' }}</td>
                            </tr>

                            <tr>
                                <th>نهاية الشيفت</th>
                                <td>{{ $shift->end_time ? $shift->end_time->format('Y-m-d h:i A') : '-' }}</td>
                            </tr>

                            <tr>
                                <th>رصيد البداية</th>
                                <td>{{ number_format((float) $shift->starting_cash, 2) }} ج.م</td>
                            </tr>

                            <tr>
                                <th>النقدية المتوقعة</th>
                                <td>{{ number_format((float) ($shift->expected_cash ?? 0), 2) }} ج.م</td>
                            </tr>

                            <tr>
                                <th>رصيد النهاية</th>
                                <td>
                                    {{ $shift->ending_cash !== null ? number_format((float) $shift->ending_cash, 2) . ' ج.م' : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>فرق النقدية</th>
                                <td>
                                    @php
                                        $diff = (float) ($shift->cash_difference ?? 0);
                                    @endphp

                                    <span
                                        class="badge badge-{{ $diff == 0 ? 'success' : ($diff > 0 ? 'info' : 'danger') }} p-2">
                                        {{ number_format($diff, 2) }} ج.م
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>ملاحظات</th>
                                <td>{{ $shift->notes ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white text-right">
                        ملخص الموظف
                    </div>

                    <div class="card-body">
                        <div class="row text-center">

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">عدد شيفتاته</div>
                                    <h4>{{ $employeeShifts->count() }}</h4>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">إجمالي البدايات</div>
                                    <h4>{{ number_format((float) $totalStartingCash, 2) }}</h4>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">إجمالي النهايات</div>
                                    <h4>{{ number_format((float) $totalEndingCash, 2) }}</h4>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="border rounded p-3 bg-light">
                                    <div class="text-muted">إجمالي فروقات النقدية</div>
                                    <h4>{{ number_format((float) $totalCashDifference, 2) }} ج.م</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-header bg-success text-white text-right">
                        ملخص فواتير هذا الشيفت
                    </div>

                    <div class="card-body">
                        <div class="row text-center">

                            <div class="col-4">
                                <div class="border rounded p-3">
                                    <div class="text-muted">عدد الفواتير</div>
                                    <h4>{{ $ordersCount }}</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="border rounded p-3">
                                    <div class="text-muted">إجمالي البيع</div>
                                    <h4>{{ number_format((float) $ordersTotal, 2) }}</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="border rounded p-3">
                                    <div class="text-muted">المدفوع</div>
                                    <h4>{{ number_format((float) $paidTotal, 2) }}</h4>
                                </div>
                            </div>

                        </div>

                        @if ($ordersCount == 0)
                            <div class="alert alert-warning text-center mt-3 mb-0">
                                لا توجد فواتير مرتبطة بهذا الشيفت، أو لم يتم ربط الطلبات بعمود shift_id بعد.
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light font-weight-bold text-right">
                فواتير / طلبات هذا الشيفت
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>النوع</th>
                            <th>طريقة الدفع</th>
                            <th>الإجمالي</th>
                            <th>المدفوع</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ optional($order->customer)->name ?? ($order->name ?? 'عام') }}</td>
                                <td>{{ $order->type }}</td>
                                <td>{{ $order->payment_method ?? '-' }}</td>
                                <td>{{ number_format((float) $order->total_price, 2) }}</td>
                                <td>{{ number_format((float) ($order->paid_amount ?? 0), 2) }}</td>
                                <td>
                                    @if ($order->status === 'served')
                                        <span class="badge badge-success">تم</span>
                                    @else
                                        <span class="badge badge-warning">معلق</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                                <td>
                                    <a href="{{ route('invoices.print', $order->id) }}" target="_blank"
                                        class="btn btn-sm btn-dark">
                                        طباعة
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted py-4">
                                    لا توجد فواتير مرتبطة بهذا الشيفت
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm" id="employeeShiftsPrintArea">
            <div class="card-header bg-light font-weight-bold d-flex justify-content-between align-items-center">
                <span>
                    كل شيفتات الموظف: {{ $shift->user->name ?? '-' }}
                </span>

                <button type="button" class="btn btn-dark btn-sm no-print" onclick="printEmployeeShifts()">
                    <i class="fas fa-print"></i>
                    طباعة شيفتات الموظف
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الفرع</th>
                            <th>البداية</th>
                            <th>النهاية</th>
                            <th>رصيد البداية</th>
                            <th>رصيد النهاية</th>
                            <th>الفرق</th>
                            <th>الحالة</th>
                            <th>عرض</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employeeShifts as $empShift)
                            <tr class="{{ $empShift->id == $shift->id ? 'table-primary' : '' }}">
                                <td>#{{ $empShift->id }}</td>
                                <td>{{ $empShift->branch->name ?? '-' }}</td>
                                <td>{{ $empShift->start_time ? $empShift->start_time->format('Y-m-d h:i A') : '-' }}</td>
                                <td>{{ $empShift->end_time ? $empShift->end_time->format('Y-m-d h:i A') : '-' }}</td>
                                <td>{{ number_format((float) $empShift->starting_cash, 2) }}</td>
                                <td>
                                    {{ $empShift->ending_cash !== null ? number_format((float) $empShift->ending_cash, 2) : '-' }}
                                </td>
                                <td>{{ number_format((float) ($empShift->cash_difference ?? 0), 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $labels[$empShift->status][0] ?? 'secondary' }}">
                                        {{ $labels[$empShift->status][1] ?? $empShift->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('shifts.show', $empShift->id) }}" class="btn btn-sm btn-info">
                                        عرض
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted py-4">
                                    لا توجد شيفتات لهذا الموظف
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection


<script>
    function printEmployeeShifts() {
        const printContent = document.getElementById('employeeShiftsPrintArea').innerHTML;

        const printWindow = window.open('', '', 'width=1000,height=700');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="ar" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <title>طباعة شيفتات الموظف</title>

                <style>
                    body {
                        font-family: Tahoma, Arial, sans-serif;
                        direction: rtl;
                        padding: 20px;
                        color: #111;
                    }

                    .card {
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        overflow: hidden;
                    }

                    .card-header {
                        background: #f8f9fa;
                        padding: 15px;
                        font-size: 20px;
                        font-weight: bold;
                        text-align: right;
                        border-bottom: 1px solid #ddd;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 0;
                    }

                    th, td {
                        border: 1px solid #ddd;
                        padding: 10px;
                        text-align: center;
                        font-size: 14px;
                    }

                    th {
                        background: #212529;
                        color: #fff;
                    }

                    tr:nth-child(even) {
                        background: #f8f9fa;
                    }

                    .badge {
                        display: inline-block;
                        padding: 5px 10px;
                        border-radius: 6px;
                        color: #fff;
                        background: #6c757d;
                    }

                    .badge-success {
                        background: #28a745;
                    }

                    .badge-warning {
                        background: #ffc107;
                        color: #111;
                    }

                    .badge-secondary {
                        background: #6c757d;
                    }

                    .btn,
                    .no-print,
                    th:last-child,
                    td:last-child {
                        display: none !important;
                    }

                    @media print {
                        body {
                            padding: 0;
                        }
                    }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
        `);

        printWindow.document.close();

        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    }
</script>