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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
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
                            <h3>{{ $stats['items_count'] }}</h3>
                            <p>إجمالي الأصناف</p>
                        </div>
                        <div class="icon"><i class="fas fa-boxes"></i></div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stats['low_stock_count'] }}</h3>
                            <p>أصناف منخفضة المخزون</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($stats['inventory_value'], 2) }}</h3>
                            <p>قيمة المخزون</p>
                        </div>
                        <div class="icon"><i class="fas fa-coins"></i></div>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stats['pending_purchase_orders'] }}</h3>
                            <p>أوامر شراء مفتوحة</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $stats['open_transfer_requests'] }}</h3>
                            <p>طلبات تحويل مفتوحة</p>
                        </div>
                        <div class="icon"><i class="fas fa-random"></i></div>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $stats['draft_stock_counts'] }}</h3>
                            <p>جلسات جرد مسودة</p>
                        </div>
                        <div class="icon"><i class="fas fa-clipboard-check"></i></div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $stats['draft_production_orders'] }}</h3>
                            <p>أوامر إنتاج مسودة</p>
                        </div>
                        <div class="icon"><i class="fas fa-industry"></i></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الأصناف منخفضة المخزون</h3>
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
                                        <td>{{ number_format($item->current_quantity ?? 0, 3) }}</td>
                                        <td>{{ number_format($item->reorder_level ?? 0, 3) }}</td>
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
        </div>
    </section>
@endsection
