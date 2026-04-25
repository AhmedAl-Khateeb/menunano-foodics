<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة #{{ $order->id }}</title>

    <style>
        @page {
            size: 80mm auto;
            margin: 4mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f4f6;
            font-family: Tahoma, Arial, sans-serif;
            color: #111827;
            font-size: 12px;
        }

        .receipt-wrapper {
            width: 80mm;
            margin: 20px auto;
            background: #fff;
            padding: 12px;
            border-radius: 14px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
        }

        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px dashed #d1d5db;
        }

        .store-name {
            font-size: 20px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .invoice-title {
            display: inline-block;
            background: #111827;
            color: #fff;
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            margin: 5px 0;
        }

        .meta {
            margin-top: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            padding: 3px 0;
            border-bottom: 1px solid #eef2f7;
        }

        .meta-row:last-child {
            border-bottom: 0;
        }

        .label {
            color: #6b7280;
            font-weight: bold;
        }

        .value {
            color: #111827;
            font-weight: bold;
            text-align: left;
        }

        .section-title {
            margin: 12px 0 6px;
            font-weight: 900;
            font-size: 13px;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        .items-table {
            border: 1px solid #e5e7eb;
        }

        .items-table thead {
            background: #111827;
            color: #fff;
        }

        .items-table th {
            padding: 7px 4px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }

        .items-table td {
            padding: 7px 4px;
            font-size: 11px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .item-name {
            text-align: right !important;
            font-weight: bold;
            max-width: 90px;
            word-break: break-word;
        }

        .item-size {
            display: block;
            margin-top: 2px;
            color: #6b7280;
            font-size: 10px;
            font-weight: normal;
        }

        .summary {
            margin-top: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            background: #fff;
        }

        .summary-row:last-child {
            border-bottom: 0;
        }

        .summary-row.total {
            background: #111827;
            color: #fff;
            font-size: 15px;
            font-weight: 900;
        }

        .footer {
            text-align: center;
            margin-top: 14px;
            padding-top: 10px;
            border-top: 2px dashed #d1d5db;
            font-weight: bold;
        }

        .thanks {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .no-print {
            text-align: center;
            margin-top: 12px;
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn {
            border: 0;
            border-radius: 8px;
            padding: 9px 16px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }

        .btn-print {
            background: #111827;
            color: #fff;
        }

        .btn-close {
            background: #e5e7eb;
            color: #111827;
        }

        @media print {
            body {
                background: #fff;
            }

            .receipt-wrapper {
                width: 80mm;
                margin: 0 auto;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

<div class="receipt-wrapper">

    <div class="header">
        <div class="store-name">nanocity</div>
        <div class="invoice-title">فاتورة بيع</div>
        <div>رقم الفاتورة: #{{ $order->id }}</div>
        <div>{{ $order->created_at->format('Y-m-d h:i A') }}</div>
    </div>

    <div class="meta">
        <div class="meta-row">
            <span class="label">نوع الطلب</span>
            <span class="value">
                @if($order->type === 'delivery')
                    توصيل
                @elseif($order->type === 'takeaway')
                    تيك أواي
                @elseif($order->type === 'table')
                    طاولة
                @elseif($order->type === 'free_seating')
                    جلوس حر
                @else
                    {{ $order->type }}
                @endif
            </span>
        </div>

        @if($order->table)
            <div class="meta-row">
                <span class="label">الطاولة</span>
                <span class="value">{{ $order->table->name }}</span>
            </div>
        @endif

        <div class="meta-row">
            <span class="label">العميل</span>
            <span class="value">{{ optional($order->customer)->name ?? $order->name ?? 'عام' }}</span>
        </div>

        <div class="meta-row">
            <span class="label">الهاتف</span>
            <span class="value">{{ optional($order->customer)->phone ?? $order->phone ?? '-' }}</span>
        </div>

        <div class="meta-row">
            <span class="label">طريقة الدفع</span>
            <span class="value">{{ $order->payment_method ?? '-' }}</span>
        </div>
    </div>

    <div class="section-title">🧾 الأصناف</div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 42%;">الصنف</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي</th>
            </tr>
        </thead>

        <tbody>
            @forelse($order->items as $item)
                @php
                    $productName = optional($item->product)->name ?? 'منتج';
                    $sizeName = $item->size ?? null;
                    $qty = $item->pivot->quantity;
                    $price = $item->pivot->price;
                    $rowTotal = $qty * $price;
                @endphp

                <tr>
                    <td class="item-name">
                        {{ $productName }}

                        @if($sizeName)
                            <span class="item-size">{{ $sizeName }}</span>
                        @endif
                    </td>
                    <td>{{ $qty }}</td>
                    <td>{{ number_format($price, 2) }}</td>
                    <td>{{ number_format($rowTotal, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">لا توجد أصناف مسجلة على الفاتورة</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        @if(($order->delivery_fee ?? 0) > 0)
            <div class="summary-row">
                <span>رسوم التوصيل</span>
                <strong>{{ number_format($order->delivery_fee, 2) }} ج.م</strong>
            </div>
        @endif

        <div class="summary-row total">
            <span>الإجمالي</span>
            <span>{{ number_format($order->total_price, 2) }} ج.م</span>
        </div>

        <div class="summary-row">
            <span>المدفوع</span>
            <strong>{{ number_format($order->paid_amount ?? 0, 2) }} ج.م</strong>
        </div>

        <div class="summary-row">
            <span>الباقي</span>
            <strong>{{ number_format($order->change_amount ?? 0, 2) }} ج.م</strong>
        </div>
    </div>

    <div class="footer">
        <div class="thanks">شكراً لزيارتكم</div>
        <small>نتمنى لكم يوماً سعيداً</small>
    </div>

    <div class="no-print">
        <button class="btn btn-print" onclick="window.print()">طباعة</button>
        <button class="btn btn-close" onclick="window.close()">إغلاق</button>
    </div>

</div>

<script>
    window.onload = function () {
        setTimeout(function () {
            window.print();
        }, 700);
    };
</script>

</body>
</html>