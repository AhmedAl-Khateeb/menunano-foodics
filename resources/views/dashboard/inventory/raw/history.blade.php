@extends('layouts.app')

@section('title', 'سجل حركات المخزون - ' . $product->name)

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="font-weight-bold mb-1">سجل حركات المخزون: <span class="text-primary">{{ $product->name }}</span></h4>
            <p class="text-muted small mb-0">تاريخ جميع الحركات (إضافة، خصم، تسوية) لهذا الصنف</p>
        </div>
        <a href="{{ route('inventory.raw.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-right ms-2"></i> عودة
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">التاريخ / الوقت</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">نوع الحركة</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">الكمية</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">الرصيد قبل</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">الرصيد بعد</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">التكلفة (للوحدة)</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">بواسطة</th>
                            <th class="text-secondary text-xs opacity-7 font-weight-bold border-bottom-0">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td class="align-middle">
                                    <span class="text-secondary text-xs font-weight-bold px-3">{{ $movement->created_at->format('Y-m-d h:i A') }}</span>
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
                                <td class="align-middle px-3 text-secondary text-xs">{{ (float)$movement->balance_before }}</td>
                                <td class="align-middle px-3 text-dark text-xs font-weight-bold">{{ (float)$movement->balance_after }}</td>
                                <td class="align-middle px-3 text-secondary text-xs">{{ number_format($movement->unit_cost ?? 0, 2) }}</td>
                                <td class="align-middle px-3 text-secondary text-xs">{{ $movement->user->name ?? 'System' }}</td>
                                <td class="align-middle px-3 text-secondary text-xs mw-100 text-truncate" style="max-width: 150px;">
                                    {{ $movement->description ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-xs text-muted font-weight-bold mb-0">لا توجد حركات مخزون مسجلة لهذا الصنف.</p>
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
@endsection
