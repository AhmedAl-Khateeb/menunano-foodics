@extends('layouts.app')

@section('main-content')
    <div class="container-fluid" dir="rtl">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="font-weight-bold">تفاصيل عهدة الكاشير: {{ $user->name }}</h3>
                <p class="text-muted mb-0">مصروفات، تسليمات للمدير، ومبالغ مرحلة للشيفت التالي.</p>
            </div>

            <a href="{{ route('cashier-cash-reports.index') }}" class="btn btn-secondary">
                رجوع
            </a>
        </div>

        <div class="row mb-4">

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted">إجمالي المصروفات</div>
                        <h4 class="text-danger font-weight-bold">
                            {{ number_format($summary['expenses_total'], 2) }} ج.م
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted">المسلم للمدير</div>
                        <h4 class="text-primary font-weight-bold">
                            {{ number_format($summary['sent_to_manager'], 2) }} ج.م
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted">المرحل للشيفت التالي</div>
                        <h4 class="text-success font-weight-bold">
                            {{ number_format($summary['carryover_total'], 2) }} ج.م
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-muted">عدد الشيفتات</div>
                        <h4 class="font-weight-bold">
                            {{ $summary['shifts_count'] }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm mb-4 printable-card" id="print-expenses">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <strong>مصروفات الكاشير</strong>

                <button type="button" class="btn btn-sm btn-light no-print" onclick="printSection('print-expenses')">
                    <i class="fas fa-print"></i>
                    طباعة
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>الشيفت</th>
                            <th>الفرع</th>
                            <th>اسم المصروف</th>
                            <th>القيمة</th>
                            <th>الحالة</th>
                            <th>ملاحظات</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td>#{{ $expense->id }}</td>
                                <td>#{{ $expense->shift_id }}</td>
                                <td>{{ $expense->branch->name ?? '-' }}</td>
                                <td>{{ $expense->title }}</td>
                                <td class="text-danger font-weight-bold">
                                    {{ number_format($expense->amount, 2) }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $expense->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ $expense->status_label ?? $expense->status }}
                                    </span>
                                </td>
                                <td>{{ $expense->notes ?? '-' }}</td>
                                <td>{{ $expense->created_at?->format('Y-m-d h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">
                                    لا توجد مصروفات
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>



        <div class="card border-0 shadow-sm mb-4 printable-card" id="print-manager-transfers">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <strong>المبالغ المسلمة للمدير</strong>

                <button type="button" class="btn btn-sm btn-light no-print"
                    onclick="printSection('print-manager-transfers')">
                    <i class="fas fa-print"></i>
                    طباعة
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>الشيفت</th>
                            <th>الفرع</th>
                            <th>المستلم</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>ملاحظات</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($managerTransfers as $transfer)
                            <tr>
                                <td>#{{ $transfer->id }}</td>
                                <td>#{{ $transfer->from_shift_id }}</td>
                                <td>{{ $transfer->branch->name ?? '-' }}</td>
                                <td>{{ $transfer->toUser->name ?? '-' }}</td>
                                <td class="text-primary font-weight-bold">
                                    {{ number_format($transfer->amount, 2) }}
                                </td>
                                <td>
                                    <span
                                        class="badge badge-{{ $transfer->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ $transfer->status_label ?? $transfer->status }}
                                    </span>
                                </td>
                                <td>{{ $transfer->notes ?? '-' }}</td>
                                <td>{{ $transfer->created_at?->format('Y-m-d h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">
                                    لا توجد مبالغ مسلمة للمدير
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>



        <div class="card border-0 shadow-sm mb-4 printable-card" id="print-carryover-transfers">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <strong>المبالغ المرحلة للشيفت التالي</strong>

                <button type="button" class="btn btn-sm btn-light no-print"
                    onclick="printSection('print-carryover-transfers')">
                    <i class="fas fa-print"></i>
                    طباعة
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>من شيفت</th>
                            <th>إلى شيفت</th>
                            <th>المستلم</th>
                            <th>المبلغ</th>
                            <th>ملاحظات</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($carryoverTransfers as $transfer)
                            <tr>
                                <td>#{{ $transfer->id }}</td>
                                <td>#{{ $transfer->from_shift_id }}</td>
                                <td>{{ $transfer->to_shift_id ? '#' . $transfer->to_shift_id : 'لم يبدأ بعد' }}</td>
                                <td>{{ $transfer->toUser->name ?? '-' }}</td>
                                <td class="text-success font-weight-bold">
                                    {{ number_format($transfer->amount, 2) }}
                                </td>
                                <td>{{ $transfer->notes ?? '-' }}</td>
                                <td>{{ $transfer->created_at?->format('Y-m-d h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    لا توجد مبالغ مرحلة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>



        <div class="card border-0 shadow-sm printable-card" id="print-shifts">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <strong>شيفتات الكاشير</strong>

                <button type="button" class="btn btn-sm btn-light no-print" onclick="printSection('print-shifts')">
                    <i class="fas fa-print"></i>
                    طباعة
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>الفرع</th>
                            <th>بداية الشيفت</th>
                            <th>نهاية الشيفت</th>
                            <th>رصيد البداية</th>
                            <th>المتوقع</th>
                            <th>رصيد النهاية</th>
                            <th>المصروفات</th>
                            <th>المسلم للمدير</th>
                            <th>المرحل</th>
                            <th>الفرق</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($shifts as $shift)
                            <tr>
                                <td>#{{ $shift->id }}</td>
                                <td>{{ $shift->branch->name ?? '-' }}</td>
                                <td>{{ $shift->start_time?->format('Y-m-d h:i A') }}</td>
                                <td>{{ $shift->end_time?->format('Y-m-d h:i A') ?? '-' }}</td>
                                <td>{{ number_format((float) $shift->starting_cash, 2) }}</td>
                                <td>{{ number_format((float) $shift->expected_cash, 2) }}</td>
                                <td>{{ number_format((float) $shift->ending_cash, 2) }}</td>
                                <td class="text-danger">{{ number_format((float) $shift->expenses_total, 2) }}</td>
                                <td class="text-primary">{{ number_format((float) $shift->sent_to_manager, 2) }}</td>
                                <td class="text-success">{{ number_format((float) $shift->carryover_to_next_shift, 2) }}
                                </td>
                                <td
                                    class="{{ (float) $shift->cash_difference < 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                                    {{ number_format((float) $shift->cash_difference, 2) }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $shift->status == 'closed' ? 'secondary' : 'success' }}">
                                        {{ $shift->status == 'closed' ? 'مغلق' : 'نشط' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-muted py-4">
                                    لا توجد شيفتات
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>




    <style>
        @media print {
            body.cashier-printing * {
                visibility: hidden !important;
            }

            body.cashier-printing .print-selected,
            body.cashier-printing .print-selected * {
                visibility: visible !important;
            }

            body.cashier-printing .print-selected {
                position: fixed !important;
                top: 0 !important;
                right: 0 !important;
                left: 0 !important;
                width: 100% !important;
                background: #fff !important;
                z-index: 999999 !important;
                padding: 15px !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                direction: rtl !important;
            }

            body.cashier-printing .print-selected .card-header {
                background: #111827 !important;
                color: #fff !important;
                text-align: center !important;
                justify-content: center !important;
                padding: 10px !important;
                font-weight: bold !important;
            }

            body.cashier-printing .print-selected .no-print,
            body.cashier-printing .print-selected button,
            body.cashier-printing .print-selected a {
                display: none !important;
                visibility: hidden !important;
            }

            body.cashier-printing .print-selected .table-responsive {
                overflow: visible !important;
            }

            body.cashier-printing .print-selected table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 12px !important;
            }

            body.cashier-printing .print-selected th,
            body.cashier-printing .print-selected td {
                border: 1px solid #333 !important;
                padding: 7px !important;
                text-align: center !important;
                vertical-align: middle !important;
                color: #000 !important;
                white-space: nowrap !important;
            }

            body.cashier-printing .print-selected th {
                background: #f1f5f9 !important;
                font-weight: bold !important;
            }

            body.cashier-printing .print-selected .badge {
                border: 1px solid #333 !important;
                color: #000 !important;
                background: #fff !important;
            }

            .main-sidebar,
            .main-header,
            .navbar,
            .content-header,
            .no-print {
                display: none !important;
                visibility: hidden !important;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }
    </style>

    <script>
        window.printSection = function(sectionId, title) {
            const section = document.getElementById(sectionId);

            if (!section) {
                alert('لم يتم العثور على الجدول المطلوب طباعته');
                return;
            }

            document.querySelectorAll('.printable-card').forEach(function(card) {
                card.classList.remove('print-selected');
            });

            section.classList.add('print-selected');
            document.body.classList.add('cashier-printing');

            setTimeout(function() {
                window.print();
            }, 200);
        };

        window.onafterprint = function() {
            document.body.classList.remove('cashier-printing');

            document.querySelectorAll('.printable-card').forEach(function(card) {
                card.classList.remove('print-selected');
            });
        };
    </script>
@endsection
