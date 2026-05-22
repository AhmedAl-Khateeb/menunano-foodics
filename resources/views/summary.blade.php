@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
    <h1>مرحبا بك في لوحة التحكم الخاصة بك</h1>
@stop

@section('main-content')

    @php
        $qrBaseUrl = env('QR_BASE_URL', config('app.url'));
        $storeName = auth()->user()->store_name;
        $storeUrl = $qrBaseUrl . '/' . $storeName;
    @endphp

    <div class="container-fluid">

        {{-- =========================
            الفلاتر
        ========================== --}}
        <div class="d-flex mb-4">

            <form method="GET"
                action="{{ route('summary') }}"
                class="d-flex flex-wrap align-items-center">

                <input type="date"
                    name="date"
                    class="form-control mx-2 mb-2"
                    value="{{ request('date') }}"
                    onchange="this.form.submit()">

                <button name="filter"
                    value="day"
                    class="btn {{ request('filter', 'day') == 'day' ? 'btn-dark' : 'btn-light' }} mx-1">
                    اليوم
                </button>

                <button name="filter"
                    value="week"
                    class="btn {{ request('filter') == 'week' ? 'btn-dark' : 'btn-light' }} mx-1">
                    الأسبوع
                </button>

                <button name="filter"
                    value="month"
                    class="btn {{ request('filter') == 'month' ? 'btn-dark' : 'btn-light' }} mx-1">
                    الشهر
                </button>

            </form>

        </div>

       

        {{-- =========================
            كروت الطلبات
        ========================== --}}
        <div class="row">

            @foreach ($orderCards ?? [] as $card)

                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">

                    <div class="card dashboard-stat-card shadow-sm border-0">

                        <div class="card-body">

                            <div class="stat-header">

                                <h6>{{ $card['title'] }}</h6>

                                <h3>{{ $card['value'] }}</h3>

                            </div>

                            <div class="chart-wrapper">

                                <canvas id="{{ $card['key'] }}"></canvas>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- =========================
            المبيعات
        ========================== --}}
        <div class="card shadow-sm border-0 mb-4 rounded">

            <div class="card-body">

                <h4 class="text-center mb-4">
                    المبيعات لكل ساعة
                </h4>

                <canvas id="salesChart"
                    height="90"></canvas>

            </div>

        </div>

        {{-- =========================
            الاحصائيات السفلية
        ========================== --}}
        <div class="row">

            {{-- أعلى المنتجات --}}
            <div class="col-md-4 mb-4">

                <div class="card shadow-sm border-0 h-100 rounded">

                    <div class="card-body">

                        <h4 class="text-center mb-4">
                            أعلى المنتجات مبيعاً
                        </h4>

                        @foreach ($topProducts ?? [] as $product)

                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    {{ $product->name }}
                                </span>

                                <strong>
                                    {{ number_format($product->total_sales, 2) }} ج
                                </strong>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            {{-- أعلى الفروع --}}
            <div class="col-md-4 mb-4">

                <div class="card shadow-sm border-0 h-100 rounded">

                    <div class="card-body">

                        <h4 class="text-center mb-4">
                            أعلى الفروع مبيعاً
                        </h4>

                        @foreach ($topBranches ?? [] as $branch)

                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    {{ optional($branch->branch)->name }}
                                </span>

                                <strong>
                                    {{ number_format($branch->total_sales, 2) }} ج
                                </strong>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            {{-- طرق الدفع --}}
            <div class="col-md-4 mb-4">

                <div class="card shadow-sm border-0 h-100 rounded">

                    <div class="card-body">

                        <h4 class="text-center mb-4">
                            طرق الدفع الأكثر استخداماً
                        </h4>

                        @foreach ($topPayments ?? [] as $payment)

                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    {{ $payment->paymentMethodRelation?->name }}
                                </span>

                                <strong>
                                    {{ $payment->total }}
                                </strong>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================
        STYLE
    ========================== --}}
    <style>

        body {
            background: #f4f5f7;
        }

        .card {
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        #qrcode canvas {
            border-radius: 10px;
        }

        .dashboard-stat-card {
            border-radius: 18px;
            background: #fff;
            height: 100%;
            overflow: hidden;
        }

        .dashboard-stat-card .card-body {
            padding: 20px;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-header h6 {
            font-size: 18px;
            font-weight: 700;
            color: #666;
            margin: 0;
        }

        .stat-header h3 {
            font-size: 48px;
            font-weight: bold;
            color: #222;
            margin: 0;
        }

        .chart-wrapper {
            width: 100%;
            height: 120px;
            position: relative;
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 120px !important;
        }

    </style>

    {{-- =========================
        SCRIPTS
    ========================== --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        // QR

        document.addEventListener('DOMContentLoaded', function () {

            new QRCode(document.getElementById("qrcode"), {
                text: "{{ $storeUrl }}",
                width: 170,
                height: 170,
            });

        });

        // COPY LINK

        function copyToClipboard() {

            const copyText = document.getElementById("storeUrl");

            copyText.select();

            document.execCommand("copy");

        }

        // DOWNLOAD QR

        function downloadQR() {

            const canvas = document.querySelector('#qrcode canvas');

            const link = document.createElement('a');

            link.download = 'store-qr.png';

            link.href = canvas.toDataURL();

            link.click();

        }

        // SHARE WHATSAPP

        function shareWhatsApp() {

            const text =
                encodeURIComponent("زور متجري الإلكتروني {{ $storeUrl }}");

            window.open(`https://wa.me/?text=${text}`, '_blank');

        }

        // SHARE TELEGRAM

        function shareTelegram() {

            const text =
                encodeURIComponent("زور متجري الإلكتروني");

            window.open(
                `https://t.me/share/url?url={{ urlencode($storeUrl) }}&text=${text}`,
                '_blank'
            );

        }

        // =========================
        // الرسومات الصغيرة
        // =========================

        function createMiniChart(chartId, data, labels) {

            const element = document.getElementById(chartId);

            if (!element) return;

            const ctx = element.getContext('2d');

            new Chart(ctx, {

                type: 'line',

                data: {

                    labels: labels,

                    datasets: [{
                        data: data,
                        borderColor: '#7E6AA8',
                        backgroundColor: 'rgba(126, 106, 168, 0.25)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        borderWidth: 2
                    }]

                },

                options: {

                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        }
                    },

                    scales: {

                        x: {
                            display: false
                        },

                        y: {
                            beginAtZero: true,
                            display: false
                        }

                    }

                }

            });

        }

        const orderCards = @json($orderCards ?? []);

        document.addEventListener('DOMContentLoaded', function () {

            orderCards.forEach(card => {

                createMiniChart(
                    card.key,
                    card.data,
                    card.labels
                );

            });

        });

        // =========================
        // رسم المبيعات
        // =========================

        new Chart(document.getElementById('salesChart'), {

            type: 'line',

            data: {

                labels: @json($salesLabels ?? []),

                datasets: [{

                    label: 'المبيعات',

                    data: @json($salesData ?? []),

                    borderColor: '#8e6ccf',

                    backgroundColor: 'rgba(142,108,207,0.15)',

                    fill: true,

                    tension: 0.4,

                    pointRadius: 4

                }]

            },

            options: {

                responsive: true,

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        });

    </script>

@stop