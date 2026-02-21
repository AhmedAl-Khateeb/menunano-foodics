@extends('layouts.app')

@section('title', 'سجل حركات المخزون - ' . $product->name)

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            {{-- Header --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white p-2 rounded-circle shadow-sm border">
                        @if($product->cover)
                            <img src="{{ $product->cover_url }}" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle text-primary" style="width: 48px; height: 48px;">
                                <i class="fas fa-box fa-lg"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 class="font-weight-bold mb-1 text-dark">{{ $product->name }}</h5>
                        <div class="d-flex align-items-center gap-2 text-muted text-sm">
                            <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'بدون قسم' }}</span>
                            <span>•</span>
                            <span>سجل الحركات</span>
                        </div>
                    </div>
                </div>
                <div>
                   <a href="{{ route('inventory.ready.index') }}" class="btn btn-white border shadow-sm">
                       <i class="fas fa-arrow-right ms-2"></i> العودة للمنتجات
                   </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="row g-3 mb-4">
                {{-- Main Stock --}}
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between relative">
                            <div class="z-index-1">
                                <p class="text-xs font-weight-bold text-muted mb-1">الرصيد الحالي (الأساسي)</p>
                                <h3 class="font-weight-bolder mb-0 text-primary">
                                    {{ $product->inventory->current_quantity ?? 0 }}
                                    <small class="text-sm font-weight-normal text-muted">{{ $product->inventory->unit->name ?? 'وحدة' }}</small>
                                </h3>
                            </div>
                            <div class="icon icon-shape bg-primary-soft text-primary rounded-circle shadow-sm">
                                <i class="fas fa-warehouse opacity-10"></i>
                            </div>
                            <div class="position-absolute start-0 top-0 w-100 h-100 bg-gradient-primary opacity-05"></div>
                        </div>
                    </div>
                </div>
                
                {{-- Sizes Stock --}}
                @if($product->sizes->count() > 0)
                <div class="col-12 col-md-8">
                    <div class="card border-0 shadow-sm h-100">
                         <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-xs font-weight-bold text-muted mb-0"><i class="fas fa-ruler-combined ms-1"></i> أرصدة الأحجام</h6>
                                <span class="badge bg-light text-secondary">{{ $product->sizes->count() }} أحجام</span>
                            </div>
                            <div class="d-flex gap-2 overflow-auto pb-2" style="scrollbar-width: thin; scrollbar-color: #dee2e6 #fff;">
                                @foreach($product->sizes as $size)
                                    <div class="border rounded p-2 text-center bg-white flex-shrink-0" style="min-width: 100px;">
                                        <span class="d-block text-xs font-weight-bold text-muted mb-1">{{ $size->size }}</span>
                                        <span class="d-block font-weight-bolder text-dark h5 mb-0">{{ $size->inventory->current_quantity ?? 0 }}</span>
                                    </div>
                                @endforeach
                            </div>
                         </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Content Area --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                     <h6 class="font-weight-bold mb-0 text-dark">
                         <i class="fas fa-history ms-2 text-primary"></i>
                         سجل العمليات
                     </h6>
                     <div class="text-xs text-muted">
                        يتم عرض آخر {{ $movements->count() }} حركة
                     </div>
                </div>
                
                {{-- Desktop View --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle mb-0">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-4">التاريخ والوقت</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7">نوع الحركة</th>
                                <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">الكمية</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7">التكلفة</th>
                                <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">الرصيد بعد</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7">البيان / المسؤول</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $movement)
                                <tr class="border-bottom-gray-100">
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="text-sm font-weight-bold text-dark">{{ $movement->created_at->format('Y-m-d') }}</span>
                                            <span class="text-xs text-muted">{{ $movement->created_at->format('h:i A') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @include('dashboard.inventory.ready.partials.movement-badge', ['type' => $movement->type])
                                    </td>
                                    <td class="text-center">
                                        <span class="text-sm font-weight-bold {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }} bg-light px-2 py-1 rounded">
                                            {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($movement->unit_cost > 0)
                                            <span class="text-xs font-weight-bold text-dark">{{ number_format($movement->unit_cost, 2) }}</span>
                                            <span class="text-xxs text-muted">ج.م</span>
                                        @else
                                            <span class="text-muted text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $movement->balance_after }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-sm font-weight-bold text-dark mb-1">{{ $movement->item_name }}</span>
                                            <div class="d-flex align-items-center gap-1 text-muted text-xs">
                                                <i class="fas fa-user-circle"></i>
                                                <span>{{ $movement->user->name ?? 'النظام' }}</span>
                                                @if($movement->description)
                                                    <span class="mx-1">•</span>
                                                    <span class="text-truncate" style="max-width: 150px;" title="{{ $movement->description }}">{{ $movement->description }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="opacity-5 mb-3"><i class="fas fa-clipboard-list fa-3x"></i></div>
                                        <p class="text-muted font-weight-bold">لا توجد حركات مسجلة</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View (Timeline) --}}
                <div class="d-block d-md-none p-3 bg-gray-50">
                    @forelse($movements as $movement)
                        <div class="timeline-block mb-3 bg-white p-3 rounded shadow-sm border border-light">
                            <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                <div class="d-flex align-items-center gap-2">
                                     @include('dashboard.inventory.ready.partials.movement-badge', ['type' => $movement->type, 'iconOnly' => true])
                                     <div class="d-flex flex-column">
                                         <span class="text-sm font-weight-bold text-dark">{{ $movement->item_name }}</span>
                                         <span class="text-xxs text-muted">{{ $movement->created_at->format('Y-m-d h:i A') }}</span>
                                     </div>
                                </div>
                                <span class="text-sm font-weight-bolder {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                </span>
                            </div>
                            
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <span class="text-xxs text-muted d-block">الرصيد بعد:</span>
                                    <span class="badge bg-light text-dark border">{{ $movement->balance_after }}</span>
                                </div>
                                <div class="col-6 border-end pe-3">
                                    <span class="text-xxs text-muted d-block">التكلفة:</span>
                                    @if($movement->unit_cost > 0)
                                        <span class="text-xs font-weight-bold text-dark">{{ number_format($movement->unit_cost, 2) }} ج.م</span>
                                    @else
                                        <span class="text-muted text-xxs">-</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-2 pt-2 border-top d-flex align-items-center gap-2 text-xs text-muted">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ $movement->user->name ?? 'النظام' }}</span>
                                @if($movement->description)
                                    <span class="mx-1">•</span>
                                    <span>{{Str::limit($movement->description, 20)}}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <p class="text-muted">لا توجد حركات مسجلة</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(94, 114, 228, 0.15) !important; }
    .bg-success-soft { background-color: rgba(45, 206, 137, 0.15) !important; color: #2dce89; }
    .bg-info-soft { background-color: rgba(17, 205, 239, 0.15) !important; color: #11cdef; }
    .bg-danger-soft { background-color: rgba(245, 54, 92, 0.15) !important; color: #f5365c; }
    .bg-warning-soft { background-color: rgba(251, 99, 64, 0.15) !important; color: #fb6340; }
    
    .timeline-block {
        position: relative;
    }
    
    .opacity-05 { opacity: 0.05; }
    .border-bottom-gray-100 { border-bottom: 1px solid #f1f3f5; }
    
    @media (max-width: 575.98px) {
        .card-header h6 { font-size: 0.95rem; }
    }
</style>
@endsection
