@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الإنتاج</h1>
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
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h3 class="card-title mb-0">أوامر الإنتاج</h3>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form action="{{ route('inventory.production-orders.index') }}" method="GET"
                            class="d-flex flex-wrap gap-2">
                            <input type="text" name="search" class="form-control form-control-sm" style="width:180px;"
                                value="{{ request('search') }}" placeholder="بحث برقم الأمر">

                            <select name="status" class="form-control form-control-sm" style="width:150px;">
                                <option value="">كل الحالات</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="produced" {{ request('status') == 'produced' ? 'selected' : '' }}>مرحّل
                                </option>
                            </select>

                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-search"></i> بحث
                            </button>

                            <a href="{{ route('inventory.production-orders.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>

                        <a href="{{ route('inventory.production-orders.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة أمر إنتاج
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الأمر</th>
                                    <th>الوصفة</th>
                                    <th>التاريخ</th>
                                    <th>الكمية المخططة</th>
                                    <th>الكمية المنتجة</th>
                                    <th>التكلفة</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productionOrders as $order)
                                    <tr>
                                        <td>{{ $productionOrders->firstItem() + $loop->index }}</td>
                                        <td>{{ $order->production_number }}</td>
                                        <td>{{ $order->recipe->outputMaterial->name ?? $order->recipe->name }}</td>
                                        <td>
                                            {{ $order->production_date?->format('Y-m-d') }}</td>
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($order->planned_quantity ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>

                                        <td>{{ rtrim(rtrim(number_format($order->produced_quantity ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>
                                        <td> {{ rtrim(rtrim(number_format($order->total_cost ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $order->status === 'produced' ? 'success' : 'secondary' }}">
                                                {{ $order->status === 'produced' ? 'مرحّل' : 'مسودة' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                                @if ($order->status !== 'produced')
                                                    <form
                                                        action="{{ route('inventory.production-orders.produce', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('inventory.production-orders.edit', $order->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form
                                                    action="{{ route('inventory.production-orders.destroy', $order->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-name="{{ $order->production_number }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">لا توجد بيانات حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $productionOrders->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
