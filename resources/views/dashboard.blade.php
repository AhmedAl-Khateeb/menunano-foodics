@extends('layouts.app')
@section('title', 'Dashboard')

@section('content_header')
    <h1>مرحبا بك في لوحة التحكم الخاصة بك</h1>
@stop

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

                            <div class="dashboard-tabs">
                                <a href="#" class="active">عام</a>
                                <a href="#">الفروع</a>
                                <a href="#">المخزون</a>
                                <a href="#">مركز الاتصال</a>
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
                                value="{{ request('date', now()->toDateString()) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- الكروت --}}
        <div class="row">
            @foreach ($orderCards as $card)
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
    </div>

    <style>
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
@stop
