@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">لوحة المخزن</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 class="text-center">{{ $stats['items_count'] }}</h3>
                            <p class="text-center">إجمالي الأصناف</p>
                        </div>
                        <div class="icon"><i class="fas fa-boxes"></i></div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 class="text-center">{{ $stats['low_stock_count'] }}</h3>
                            <p class="text-center">أصناف منخفضة المخزون</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 class="text-center">
                                {{ rtrim(rtrim(number_format($stats['inventory_value'], 2, '.', ''), '0'), '.') }}</h3>
                            <p class="text-center">قيمة المخزون</p>
                        </div>
                        <div class="icon"><i class="fas fa-coins"></i></div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="text-center">{{ $stats['pending_purchase_orders'] }}</h3>
                            <p class="text-center">أوامر شراء مفتوحة</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 class="text-center">{{ $stats['open_transfer_requests'] }}</h3>
                            <p class="text-center">طلبات تحويل مفتوحة</p>
                        </div>
                        <div class="icon"><i class="fas fa-random"></i></div>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 class="text-center">{{ $stats['draft_stock_counts'] }}</h3>
                            <p class="text-center">جلسات جرد مسودة</p>
                        </div>
                        <div class="icon"><i class="fas fa-clipboard-check"></i></div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3 class="text-center">{{ $stats['draft_production_orders'] }}</h3>
                            <p class="text-center">أوامر إنتاج مسودة</p>
                        </div>
                        <div class="icon"><i class="fas fa-industry"></i></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class=" text-center">الأصناف منخفضة المخزون</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>الصنف</th>
                                    <th>الرصيد الحالي</th>
                                    <th>حد الطلب</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockItems as $item)
                                    <tr>
                                        <td>{{ $item->inventoriable->name ?? '-' }}</td>
                                        <td>{{ rtrim(rtrim(number_format($item->current_quantity ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($item->reorder_level ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">لا توجد أصناف منخفضة المخزون حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <ol class="float-sm-right mb-0 p-0" style="list-style: none;">
                    <li>
                        <a href="{{ route('dashboard') }}" class="btn btn-success"
                            style="color: #fff; transition: all 0.2s ease-in-out;"
                            onmouseover="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff'; this.style.color='#fff';"
                            onmouseout="this.style.backgroundColor=''; this.style.borderColor=''; this.style.color='#fff';">
                            الرئيسية
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </section>
@endsection
