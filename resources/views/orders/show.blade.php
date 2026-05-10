@extends('layouts.app')

@section('main-content')
    <div class="container my-5">
        <div class="card shadow-lg rounded-lg">

            <div
                class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">

                <h3 class="mb-0 font-weight-bold" style="letter-spacing: 1px;">تفاصيل الطلب</h3>

                <div class="d-flex align-items-center flex-wrap gap-2">

                    <button type="button" class="btn btn-light btn-sm px-3 shadow-sm mr-2" onclick="printOrderDetails()">
                        <i class="fa fa-print text-primary"></i> طباعة
                    </button>

                    @if ($order->status != 'served')
                        <x-model name="serve-{{ $order->id }}" status="success" icon="fa fa-check" title="تأكيد التوصيل"
                            message="هل تم توصيل هذا الطلب؟">
                            <form action="{{ route('orders.serve', $order->id) }}" method="POST" class="mb-0">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-light btn-sm px-3 shadow-sm">
                                    <i class="fa fa-check text-success"></i> نعم
                                </button>
                            </form>
                        </x-model>
                    @endif

                    <span class="badge badge-light text-secondary px-3 py-2"
                        style="font-size: 0.9rem; border-radius: 20px;">
                        {{ $order->created_at->diffForHumans() }}
                    </span>

                </div>
            </div>

            <div class="card-body">

                {{-- منطقة الطباعة --}}
                <div id="print-order-area">

                    <div class="print-header text-center mb-4">
                        <h3 class="font-weight-bold mb-1">تفاصيل الطلب</h3>
                        <p class="mb-0">رقم الطلب: {{ $order->id }}</p>
                        <p class="mb-0">التاريخ: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="row mb-4 text-center">

                        <div class="col-md-3">
                            <p>
                                <strong>اسم الكاشير:</strong>
                                <span class="text-primary font-weight-bold">
                                    {{ $order->cashier->name ?? '-' }}
                                </span>
                            </p>
                        </div>

                        <div class="col-md-3">
                            <p>
                                <strong>الحالة:</strong>
                                <span class="text-primary font-weight-bold">
                                    @if ($order->status == 'served')
                                        تم
                                    @elseif ($order->status == 'returned')
                                        مرتجع
                                    @else
                                        انتظار
                                    @endif
                                </span>
                            </p>
                        </div>

                        <div class="col-md-3">
                            <p>
                                <strong>طريقة الدفع:</strong>
                                <span class="badge badge-info">
                                    {{ $order->payment_method == 'cash' ? 'دفع نقدي' : $order->payment_method }}
                                </span>
                            </p>
                        </div>

                        <div class="col-md-3">
                            <p>
                                <strong>الإجمالي:</strong>
                                <span class="text-success font-weight-bold">
                                    {{ number_format($order->total_price, 2) }} ر.س
                                </span>
                            </p>
                        </div>

                    </div>

                    @if ($order->payment_proof)
                        <div class="row mb-4 no-print-image">
                            <div class="col-12">
                                <h5 class="mb-3 text-secondary font-weight-bold">إثبات الدفع:</h5>
                                <div class="border rounded p-2 d-inline-block bg-light shadow-sm">
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="إثبات الدفع"
                                            class="img-fluid rounded" style="max-height: 250px; cursor: pointer;">
                                    </a>
                                    <div class="mt-2 text-center">
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-expand"></i> عرض الحجم الكامل
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h4 class="mb-3 border-bottom pb-2">تفاصيل المنتجات</h4>

                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle mb-0 print-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th>الحجم</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="font-weight-bold text-primary">
                                            {{ $item->product->name ?? '-' }}
                                        </td>

                                        <td>{{ $item->size ?? '-' }}</td>

                                        <td>{{ number_format($item->pivot->price, 2) }} ر.س</td>

                                        <td>{{ $item->pivot->quantity }}</td>

                                        <td>
                                            {{ number_format($item->pivot->price * $item->pivot->quantity, 2) }} ر.س
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end font-weight-bold">السعر الكلي</td>
                                    <td class="font-weight-bold">
                                        {{ number_format($order->total_price, 2) }} ر.س
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

                {{-- أزرار الصفحة --}}
                <div class="mt-4 d-flex align-items-center flex-wrap gap-2">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary px-4 shadow-sm">
                        <i class="fa fa-arrow-left mr-2"></i> العودة
                    </a>

                    <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="printOrderDetails()">
                        <i class="fa fa-print mr-2"></i> طباعة الطلب
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script>
        function printOrderDetails() {
            const printArea = document.getElementById('print-order-area');

            if (!printArea) {
                alert('Print area not found');
                return;
            }

            const printContent = printArea.innerHTML;

            const printWindow = window.open('', '_blank', 'width=900,height=700');

            printWindow.document.open();

            printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="ar" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <title>طباعة الطلب</title>

                <style>
                    @page {
                        size: A4;
                        margin: 8mm;
                    }

                    html,
                    body {
                        direction: rtl;
                        text-align: right;
                        font-family: Arial, Tahoma, sans-serif;
                        color: #000;
                        background: #fff;
                        margin: 0;
                        padding: 0;
                        font-size: 14px;
                        width: 100%;
                    }

                    body {
                        display: flex;
                        justify-content: center;
                    }

                    #print-card {
                        width: 100%;
                        max-width: 190mm;
                        min-height: auto;
                        border: 1px solid #ddd;
                        padding: 10mm;
                        box-sizing: border-box;
                    }

                    .print-header {
                        display: block !important;
                        text-align: center;
                        margin-bottom: 20px;
                        padding-bottom: 12px;
                        border-bottom: 2px solid #000;
                    }

                    .print-header h3 {
                        margin: 0 0 8px 0;
                        font-size: 24px;
                        font-weight: bold;
                    }

                    .print-header p {
                        margin: 4px 0;
                        font-size: 14px;
                    }

                    .row {
                        display: flex;
                        flex-wrap: wrap;
                        margin: 0 0 15px 0;
                        width: 100%;
                    }

                    .col-md-3 {
                        width: 25%;
                        box-sizing: border-box;
                        padding: 6px 10px;
                    }

                    p {
                        margin: 5px 0;
                    }

                    strong {
                        font-weight: bold;
                    }

                    h4 {
                        font-size: 18px;
                        margin: 20px 0 10px;
                        padding-bottom: 8px;
                        border-bottom: 1px solid #999;
                    }

                    .table-responsive {
                        width: 100%;
                        overflow: visible !important;
                    }

                    table {
                        width: 100% !important;
                        border-collapse: collapse;
                        margin-top: 10px;
                        font-size: 14px;
                    }

                    table th,
                    table td {
                        border: 1px solid #333;
                        padding: 9px 7px;
                        text-align: center;
                        vertical-align: middle;
                    }

                    table th {
                        background: #f2f2f2;
                        font-weight: bold;
                    }

                    tfoot td {
                        font-weight: bold;
                        background: #fafafa;
                    }

                    .text-primary,
                    .text-success {
                        color: #000 !important;
                    }

                    .badge {
                        display: inline-block;
                        padding: 4px 8px;
                        border: 1px solid #333;
                        border-radius: 4px;
                        color: #000;
                        background: #f7f7f7;
                    }

                    .no-print-image {
                        display: none !important;
                    }

                    @media print {
                        html,
                        body {
                            width: 100%;
                            margin: 0 !important;
                            padding: 0 !important;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }

                        body {
                            display: block;
                        }

                        #print-card {
                            width: 100%;
                            max-width: none;
                            border: 0;
                            padding: 0;
                        }
                    }
                </style>
            </head>

            <body>
                <div id="print-card">
                    ${printContent}
                </div>
            </body>
            </html>
        `);

            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.focus();

                setTimeout(function() {
                    printWindow.print();

                    setTimeout(function() {
                        printWindow.close();
                    }, 700);
                }, 300);
            };
        }
    </script>


    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .table-hover tbody tr:hover {
            background: #e9f0ff !important;
            transition: background-color 0.3s ease;
        }

        .shadow-sm {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            color: #fff;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-radius: 15px 15px 0 0;
        }

        .gap-2 {
            gap: 8px;
        }

        .print-header {
            display: none;
        }
    </style>
@endsection
