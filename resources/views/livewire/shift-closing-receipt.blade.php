<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير إغلاق الشفت</title>

    <style>
        @page {
            size: 80mm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: Tahoma, Arial, sans-serif;
            color: #000;
            direction: rtl;
        }

        .print-container {
            display: flex;
            flex-direction: column;
        }

        .receipt {
            width: 72mm;
            padding: 8px 6px;
            margin: 0 auto;
            font-size: 11px;
            line-height: 1.5;

            page-break-inside: avoid;
            break-inside: avoid;
            page-break-after: avoid;
            display: block;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin: 3px 0;
        }

        .row span {
            flex: 1;
        }

        .row strong {
            font-weight: bold;
            text-align: left;
            direction: ltr;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            margin: 7px 0 4px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 3px 0;
        }

        .total-row {
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }

        .note {
            margin-top: 6px;
            font-size: 10px;
        }

        .ltr {
            direction: ltr;
            unicode-bidi: embed;
        }

        @media screen {
            body {
                background: #eee;
                padding: 20px;
            }

            .receipt {
                background: #fff;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
            }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }
        }

        @media print {

            html,
            body {
                width: 80mm;
                margin: 0 !important;
                padding: 0 !important;
            }

            .print-container {
                width: 80mm;
            }
        }

        .receipt {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .print-container {
            display: block !important;
        }
    </style>
</head>

<body>

    @php
        $shiftNotes = $shift->notes ?? ($shift->close_note ?? '');
    @endphp

    <div class="print-container">

        <!-- ===================== -->
        <!-- الفاتورة الأولى -->
        <!-- ===================== -->
        <div class="receipt">

            <div class="center">
                <div class="title">تقرير إغلاق وردية كاشير</div>
                <div class="subtitle">{{ config('app.name') }}</div>
            </div>

            <div class="line"></div>

            <div class="row">
                <span>رقم الشفت</span>
                <strong>{{ $shift->id }}</strong>
            </div>

            <div class="row">
                <span>الكاشير</span>
                <strong>{{ $cashier->name ?? '-' }}</strong>
            </div>

            <div class="row">
                <span>الفرع</span>
                <strong>{{ $branch->name ?? '-' }}</strong>
            </div>

            <div class="row">
                <span>بداية الشفت</span>
                <strong class="ltr">{{ optional($shift->start_time)->format('Y-m-d H:i') }}</strong>
            </div>

            <div class="row">
                <span>نهاية الشفت</span>
                <strong class="ltr">{{ optional($shift->end_time)->format('Y-m-d H:i') }}</strong>
            </div>

            <div class="line"></div>

            <div class="center">
                <strong>ملخص الشفت</strong>
            </div>

            <div class="row">
                <span>عدد الطلبات</span>
                <strong>{{ $ordersCount }}</strong>
            </div>

            <div class="row">
                <span>إجمالي المبيعات</span>
                <strong>{{ number_format($ordersTotal, 2) }}</strong>
            </div>

        </div>

        <!-- ===================== -->
        <!-- الفاتورة الثانية -->
        <!-- ===================== -->
        <div class="receipt">

            <div class="center">
                <div class="title">تفاصيل الدفعات والدرج</div>
            </div>

            <div class="line"></div>

            @foreach ($paymentsBreakdown as $item)
                <div class="row">
                    <span>{{ $item['name'] }}</span>
                    <strong>{{ number_format($item['total'], 2) }}</strong>
                </div>
            @endforeach

            <div class="line"></div>

            <div class="row">
                <span>المبيعات النقدية</span>
                <strong>{{ number_format($cashSales, 2) }}</strong>
            </div>

            <div class="row">
                <span>مبيعات الفيزا</span>
                <strong>{{ number_format($visaSales, 2) }}</strong>
            </div>

            <div class="row">
                <span>مرتجع نقدي</span>
                <strong>{{ number_format($cashRefund, 2) }}</strong>
            </div>

            <div class="row">
                <span>مرتجع فيزا</span>
                <strong>{{ number_format($visaRefund, 2) }}</strong>
            </div>

            <div class="line"></div>

            <div class="row total-row">
                <span>المتوقع</span>
                <strong>{{ number_format($expectedCash, 2) }}</strong>
            </div>

            <div class="row total-row">
                <span>الفعلي</span>
                <strong>{{ number_format($endingCash, 2) }}</strong>
            </div>

            <div class="row total-row">
                <span>الفرق</span>
                <strong>
                    @if ($difference > 0)
                        زيادة {{ number_format($difference, 2) }}
                    @elseif ($difference < 0)
                        عجز {{ number_format(abs($difference), 2) }}
                    @else
                        0.00
                    @endif
                </strong>
            </div>

            @if (!empty($shiftNotes))
                <div class="line"></div>
                <div class="note">
                    <strong>ملاحظات:</strong><br>
                    {{ $shiftNotes }}
                </div>
            @endif

            <div class="line"></div>

            <div class="center">
                شكراً لك
                <br>
                {{ now()->format('Y-m-d H:i') }}
            </div>

        </div>

    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(() => window.print(), 500);
        });
    </script>

</body>

</html>
