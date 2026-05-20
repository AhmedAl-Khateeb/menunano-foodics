@extends('layouts.app')
@section('title', 'Dashboard')

@section('content_header')
    <h1>مرحبا بك في لوحة التحكم الخاصة بك</h1>
@stop


@php
    $subscriptionExpired =
        auth()->check() &&
        auth()->user()->role !== 'super_admin' &&
        method_exists(auth()->user(), 'hasActiveSubscription') &&
        !auth()->user()->hasActiveSubscription();
@endphp
@section('main-content')
    <div class="container-fluid dashboard-page">
        {{-- الجزء العلوي --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-top-bar">
                    <div class="dashboard-top-content">

                        {{-- اليمين: العنوان + التبويبات --}}
                        <div class="dashboard-top-right">
                            <h2 class="dashboard-welcome">مرحبًا، {{ auth()->user()->name }}</h2>

                            <div class="dashboard-tabs {{ $subscriptionExpired ? 'disabled-dashboard-links' : '' }}">
                                <a href="javascript:void(0)" class="active">عام</a>
                                <a href="{{ route('branches.index') }}">الفروع</a>
                                <a href="{{ route('inventory.dashboard') }}">المخزون</a>
                                <a href="{{ route('settings.index') }}">مركز الاتصال</a>
                            </div>
                        </div>

                        {{-- الشمال: الفلاتر + التاريخ --}}
                        <div class="dashboard-top-left">
                            <div class="btn-group filter-group" role="group">
                                <a href="{{ route('dashboard', ['filter' => 'day']) }}"
                                    class="btn btn-filter {{ request('filter', 'day') == 'day' ? 'active' : '' }}">
                                    اليوم
                                </a>

                                <a href="{{ route('dashboard', ['filter' => 'week']) }}"
                                    class="btn btn-filter {{ request('filter') == 'week' ? 'active' : '' }}">
                                    الأسبوع
                                </a>

                                <a href="{{ route('dashboard', ['filter' => 'month']) }}"
                                    class="btn btn-filter {{ request('filter') == 'month' ? 'active' : '' }}">
                                    الشهر
                                </a>
                            </div>

                            <input type="date" class="form-control date-filter"
                                value="{{ request('date', now()->toDateString()) }}"
                                onchange="window.location.href='?filter={{ request('filter', 'day') }}&date=' + this.value">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Store QR Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm store-qr-card">
                    <div class="card-body">

                        <div class="row align-items-center">

                            {{-- Right Side --}}
                            <div class="col-lg-8 mb-4 mb-lg-0">

                                <div class="d-flex align-items-center mb-3">
                                    <div class="store-icon">
                                        <i class="fas fa-store"></i>
                                    </div>

                                    <div class="mr-3">
                                        <h3 class="mb-1 font-weight-bold">
                                            متجرك الإلكتروني
                                        </h3>

                                        <p class="text-muted mb-0">
                                            شارك رابط متجرك مع العملاء بسهولة
                                        </p>
                                    </div>
                                </div>

                                {{-- Store URL --}}
                                <div class="store-link-box">

                                    <input type="text" id="storeUrl" class="form-control" value="{{ $storeUrl }}"
                                        readonly>

                                    <div class="store-link-actions">

                                        <button class="btn btn-copy" onclick="copyToClipboard()">

                                            <i class="fas fa-copy"></i>
                                        </button>

                                        <a href="{{ $storeUrl }}" target="_blank" class="btn btn-open">

                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                    </div>

                                </div>

                                {{-- Buttons --}}
                                <div class="mt-4 d-flex flex-wrap gap-2">

                                    <button class="btn btn-success" onclick="downloadQR()">

                                        <i class="fas fa-download ml-1"></i>
                                        تحميل QR
                                    </button>

                                    <button class="btn btn-whatsapp" onclick="shareWhatsApp()">

                                        <i class="fab fa-whatsapp ml-1"></i>
                                        واتساب
                                    </button>

                                    <button class="btn btn-telegram" onclick="shareTelegram()">

                                        <i class="fab fa-telegram ml-1"></i>
                                        تيليجرام
                                    </button>

                                </div>

                            </div>

                            {{-- QR Side --}}
                            <div class="col-lg-4 text-center">

                                <div class="qr-wrapper">

                                    <div id="qrcode"></div>

                                </div>

                                <small class="text-muted d-block mt-3">
                                    امسح الكود للوصول السريع للمتجر
                                </small>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- الكروت --}}
        <div class="row">
            @foreach ($orderCards as $card)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div
                        class="card dashboard-stat-card shadow-sm border-0 {{ $subscriptionExpired ? 'expired-overlay-card' : '' }}">
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
        {{-- رسم المبيعات --}}
        <div class="row mt-4">

            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h5 class="mb-4 text-center">المبيعات لكل ساعة</h5>

                        <div style="height:350px">
                            <canvas id="salesChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- الكروت السفلية --}}
        <div class="row">

            {{-- طرق الدفع --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">

                        <h5 class="mb-4 text-center">طرق الدفع الأكثر استخدامًا</h5>

                        @foreach ($topPayments as $payment)
                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    {{ $payment->paymentMethodRelation->name ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>

                                <strong>{{ $payment->total }}</strong>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- أعلى الفروع --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">

                        <h5 class="mb-4 text-center">أعلى الفروع مبيعًا</h5>

                        @foreach ($topBranches as $branch)
                            <div class="d-flex justify-content-between mb-3">

                                <span>
                                    {{ $branch->branch->name ?? 'بدون فرع' }}
                                </span>

                                <strong>
                                    {{ number_format($branch->total_sales, 2) }} ج
                                </strong>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- أعلى المنتجات --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">

                        <h5 class="mb-4 text-center">أعلى المنتجات مبيعًا</h5>

                        @foreach ($topProducts as $product)
                            <div class="d-flex justify-content-between mb-3">

                                <span>{{ $product->name }}</span>

                                <strong>
                                    {{ number_format($product->total_sales, 2) }} ج
                                </strong>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>

    </div>


    </div>

    <style>
        .disabled-dashboard-links {
            pointer-events: none;
            opacity: 0.6;
        }

        .expired-overlay-card {
            position: relative;
            opacity: 0.7;
            pointer-events: none;
            overflow: hidden;
        }

        .expired-overlay-card::after {
            content: 'الباقة منتهية';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.55);
            color: #b45309;
            font-size: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .expired-message-bar {
            background: linear-gradient(90deg, #fff3cd, #ffe08a);
            color: #7a5200;
            border: 1px solid #f4d06f;
            border-radius: 14px;
            padding: 16px 20px;
            margin: 0 0 20px 0;
            font-weight: 700;
            text-align: right;
        }

        .dashboard-page {
            direction: rtl;
        }

        .dashboard-top-bar {
            background: #eef1f5;
            border-radius: 14px;
            padding: 24px 28px;
        }

        .dashboard-top-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .dashboard-top-right {
            text-align: right;
        }

        .dashboard-welcome {
            font-size: 42px;
            font-weight: 700;
            color: #222;
            margin-bottom: 12px;
        }

        .dashboard-tabs {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 28px;
            flex-wrap: wrap;
        }

        .dashboard-tabs a {
            text-decoration: none;
            color: #666;
            font-size: 18px;
            font-weight: 600;
            position: relative;
            padding-bottom: 6px;
        }

        .dashboard-tabs a.active {
            color: #7a69ac;
        }

        .dashboard-tabs a.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: 0;
            width: 100%;
            height: 2px;
            background: #7a69ac;
            border-radius: 3px;
        }

        .dashboard-top-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-group {
            direction: rtl;
        }

        .btn-filter {
            background: #fff;
            border: 1px solid #d9dde3;
            color: #555;
            min-width: 78px;
            font-weight: 600;
            border-radius: 0;
            box-shadow: none !important;
        }

        .btn-filter.active {
            background: #4a4f57;
            color: #fff;
            border-color: #4a4f57;
        }

        .filter-group .btn:first-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .filter-group .btn:last-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .date-filter {
            width: 150px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid #d9dde3;
            box-shadow: none !important;
        }

        .dashboard-stat-card {
            border-radius: 18px;
            background: #fff;
            min-height: 250px;
        }

        .dashboard-stat-card .card-body {
            padding: 20px;
        }

        .stat-header {
            text-align: right;
            margin-bottom: 14px;
        }

        .stat-header h6 {
            font-size: 18px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
        }

        .stat-header h3 {
            font-size: 52px;
            font-weight: 700;
            color: #222;
            line-height: 1;
            margin: 0;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 140px;
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .store-qr-card {
            border-radius: 22px;
            overflow: hidden;
            background:
                linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        }

        .store-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: linear-gradient(135deg, #7E6AA8, #5f4b8b);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .store-link-box {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            padding: 6px;
        }

        .store-link-box input {
            border: 0 !important;
            box-shadow: none !important;
            background: transparent;
            font-size: 15px;
            direction: ltr;
        }

        .store-link-actions {
            display: flex;
            gap: 8px;
        }

        .store-link-actions .btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 0;
        }

        .btn-copy {
            background: #f3f4f6;
            color: #333;
        }

        .btn-open {
            background: #7E6AA8;
            color: white;
        }

        .btn-whatsapp {
            background: #25D366;
            color: white;
        }

        .btn-telegram {
            background: #229ED9;
            color: white;
        }

        .qr-wrapper {
            background: white;
            border-radius: 22px;
            padding: 20px;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            border: 1px solid #eee;
        }

        #qrcode canvas {
            border-radius: 10px;
        }

        .gap-2 {
            gap: 10px;
        }

        @media(max-width:768px) {

            .store-link-box {
                flex-direction: column;
                gap: 10px;
            }

            .store-link-actions {
                width: 100%;
            }

            .store-link-actions .btn {
                flex: 1;
            }

        }

        @media (max-width: 992px) {
            .dashboard-welcome {
                font-size: 30px;
            }

            .dashboard-tabs a {
                font-size: 16px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-top-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .dashboard-top-right {
                width: 100%;
            }

            .dashboard-tabs {
                justify-content: flex-start;
                gap: 18px;
            }

            .dashboard-top-left {
                width: 100%;
            }

            .stat-header h3 {
                font-size: 38px;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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
                        pointBackgroundColor: '#7E6AA8',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#ececec',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#777',
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f1f1',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#777',
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }

        const orderCards = @json($orderCards);

        document.addEventListener('DOMContentLoaded', function() {
            orderCards.forEach(card => {
                createMiniChart(card.key, card.data, card.labels);
            });
        });
    </script>


    <script>
        const salesCtx = document.getElementById('salesChart');

        if (salesCtx) {

            new Chart(salesCtx, {
                type: 'line', // 👈 هنا التغيير الأساسي
                data: {
                    labels: @json($salesLabels),
                    datasets: [{
                        label: 'المبيعات',
                        data: @json($salesData),

                        fill: true, // 👈 يخلي تحت الخط متلوّن زي الكروت
                        tension: 0.4, // 👈 يخلي الخط ناعم
                        borderColor: '#7E6AA8',
                        backgroundColor: 'rgba(126, 106, 168, 0.20)',
                        pointBackgroundColor: '#7E6AA8',
                        pointRadius: 4,
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
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#eee'
                            }
                        }
                    }
                }
            });

        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const qrContainer = document.getElementById('qrcode');

            if (qrContainer) {

                new QRCode(qrContainer, {
                    text: "{{ $storeUrl }}",
                    width: 180,
                    height: 180,
                    colorDark: "#111827",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

            }

        });

        function copyToClipboard() {

            const input = document.getElementById('storeUrl');

            input.select();
            input.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(input.value);

            Swal.fire({
                icon: 'success',
                title: 'تم النسخ',
                text: 'تم نسخ رابط المتجر',
                timer: 1800,
                showConfirmButton: false
            });

        }

        function downloadQR() {

            const qrCanvas = document.querySelector('#qrcode canvas');

            if (!qrCanvas) return;

            const link = document.createElement('a');

            link.download = 'store-qr.png';

            link.href = qrCanvas.toDataURL();

            link.click();

        }

        function shareWhatsApp() {

            const text = encodeURIComponent(
                `زر متجري الآن 👋\n{{ $storeUrl }}`
            );

            window.open(`https://wa.me/?text=${text}`, '_blank');

        }

        function shareTelegram() {

            const text = encodeURIComponent('زر متجري الإلكتروني');

            window.open(
                `https://t.me/share/url?url={{ urlencode($storeUrl) }}&text=${text}`,
                '_blank'
            );

        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('subscription_expired'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: @json(session('subscription_expired')),
                confirmButtonText: 'حسنًا',
                confirmButtonColor: '#f59e0b'
            });
        </script>
    @endif

    @if (session('permission_denied'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'غير متاح',
                text: @json(session('permission_denied')),
                confirmButtonText: 'حسنًا',
                confirmButtonColor: '#f59e0b'
            });
        </script>
    @endif

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
@stop
