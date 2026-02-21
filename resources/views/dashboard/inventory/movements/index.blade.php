@extends('layouts.app')

@section('title', 'حركات المخزون')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="font-weight-bold mb-1">حركات المخزون</h4>
            <p class="text-muted small mb-0">سجل شامل لجميع عمليات المخزون (شراء، بيع، هالك، تسوية)</p>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        {{-- Purchase Stats --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-xs font-weight-bold mb-0">إجمالي الشراء</p>
                        <h5 class="font-weight-bold mb-0 text-success">+{{ number_format($stats['purchase'], 2) }}</h5>
                    </div>
                    <div class="icon icon-shape bg-success-soft text-success rounded-circle shadow-sm">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                </div>
            </div>
        </div>
        {{-- Waste Stats --}}
        <div class="col-md-3">
             <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-xs font-weight-bold mb-0">إجمالي الهالك</p>
                        <h5 class="font-weight-bold mb-0 text-danger">-{{ number_format($stats['waste'], 2) }}</h5>
                    </div>
                    <div class="icon icon-shape bg-danger-soft text-danger rounded-circle shadow-sm">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        {{-- Sale Stats --}}
        <div class="col-md-3">
             <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-xs font-weight-bold mb-0">إجمالي المبيعات</p>
                        <h5 class="font-weight-bold mb-0 text-info">{{ number_format($stats['sale'], 2) }}</h5>
                    </div>
                    <div class="icon icon-shape bg-info-soft text-info rounded-circle shadow-sm">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
            </div>
        </div>
        {{-- Adjustment Stats --}}
         <div class="col-md-3">
             <div class="card border-0 shadow-sm">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-xs font-weight-bold mb-0">صافي التسويات</p>
                        <h5 class="font-weight-bold mb-0 {{ $stats['adjustment'] >= 0 ? 'text-primary' : 'text-warning' }}">
                            {{ $stats['adjustment'] > 0 ? '+' : '' }}{{ number_format($stats['adjustment'], 2) }}
                        </h5>
                    </div>
                    <div class="icon icon-shape bg-warning-soft text-warning rounded-circle shadow-sm">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('inventory.movements.index') }}" method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    {{-- Movement Type --}}
                    <div class="col-md-3">
                        <label class="form-label text-xs font-weight-bold">نوع الحركة</label>
                        <select name="type" class="form-select form-select-sm border-2 shadow-none" onchange="this.form.submit()">
                            <option value="">الكل</option>
                            <option value="purchase" {{ request('type') == 'purchase' ? 'selected' : '' }}>شراء / توريد</option>
                            <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>بيع</option>
                            <option value="waste" {{ request('type') == 'waste' ? 'selected' : '' }}>هالك / تالف</option>
                            <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>تسوية جرد</option>
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-3">
                        <label class="form-label text-xs font-weight-bold">الفئة</label>
                        <select name="category_id" class="form-select form-select-sm border-2 shadow-none" onchange="this.form.submit()">
                            <option value="">كل الفئات</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date Range --}}
                    <div class="col-md-3">
                        <label class="form-label text-xs font-weight-bold">التاريخ</label>
                        <select name="date_range" class="form-select form-select-sm border-2 shadow-none" id="dateRangeSelect" onchange="toggleCustomDate(this.value); this.form.submit()">
                            <option value="">كل الوقت</option>
                            <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>اليوم</option>
                            <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>أمس</option>
                            <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>آخر 7 أيام</option>
                            <option value="14days" {{ request('date_range') == '14days' ? 'selected' : '' }}>آخر 14 يوم</option>
                            <option value="28days" {{ request('date_range') == '28days' ? 'selected' : '' }}>آخر 28 يوم</option>
                            <option value="60days" {{ request('date_range') == '60days' ? 'selected' : '' }}>آخر 60 يوم</option>
                            <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>مخصص...</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    <div class="col-md-3 text-end">
                        <a href="{{ route('inventory.movements.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                             <i class="fas fa-undo ms-1"></i> إعادة تعيين
                        </a>
                    </div>
                </div>

                {{-- Custom Date Inputs (Hidden by default) --}}
                <div class="row g-3 mt-2 {{ request('date_range') == 'custom' ? '' : 'd-none' }}" id="customDateRow">
                    <div class="col-md-6">
                        <label class="form-label text-xs">من تاريخ</label>
                        <input type="date" name="start_date" class="form-control form-control-sm border-2 shadow-none" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-xs">إلى تاريخ</label>
                        <input type="date" name="end_date" class="form-control form-control-sm border-2 shadow-none" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-12 text-end">
                         <button type="submit" class="btn btn-primary btn-sm px-4">تطبيق الفلتر</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Results Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">التاريخ</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">المنتج / الصنف</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">نوع الحركة</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">الكمية</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">الرصيد بعد</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">التكلفة</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold">بواسطة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td class="align-middle px-3">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $movement->created_at->format('Y-m-d h:i A') }}</span>
                                </td>
                                <td class="align-middle px-3">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm font-weight-bold">{{ $movement->inventory->inventoriable->name ?? 'غير معروف' }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $movement->inventory->inventoriable->category->name ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="align-middle px-3">
                                     @if($movement->type == 'purchase')
                                        <span class="badge badge-sm bg-gradient-success">شراء / توريد</span>
                                    @elseif($movement->type == 'waste')
                                        <span class="badge badge-sm bg-gradient-danger">هالك / تالف</span>
                                    @elseif($movement->type == 'adjustment')
                                        <span class="badge badge-sm bg-gradient-warning">تسوية جرد</span>
                                    @elseif($movement->type == 'sale')
                                        <span class="badge badge-sm bg-gradient-info">بيع</span>
                                    @else
                                        <span class="badge badge-sm bg-secondary">{{ $movement->type }}</span>
                                    @endif
                                </td>
                                <td class="align-middle px-3">
                                    <span class="text-xs font-weight-bold {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}" dir="ltr">
                                        {{ $movement->quantity > 0 ? '+' : '' }}{{ (float)$movement->quantity }}
                                    </span>
                                </td>
                                <td class="align-middle px-3 text-dark text-xs font-weight-bold">{{ (float)$movement->balance_after }}</td>
                                <td class="align-middle px-3 text-secondary text-xs">
                                    {{ number_format($movement->unit_cost ?? 0, 2) }}
                                </td>
                                <td class="align-middle px-3 text-secondary text-xs">{{ $movement->user->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-xs text-muted font-weight-bold mb-0">لا توجد حركات مطابقة للفلتر.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($movements->hasPages())
            <div class="card-footer py-3">
                {{ $movements->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(45, 206, 137, 0.1) !important; color: #2dce89; }
    .bg-danger-soft { background-color: rgba(245, 54, 92, 0.1) !important; color: #f5365c; }
    .bg-info-soft { background-color: rgba(17, 205, 239, 0.1) !important; color: #11cdef; }
    .bg-warning-soft { background-color: rgba(251, 99, 64, 0.1) !important; color: #fb6340; }
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
</style>
@endsection
