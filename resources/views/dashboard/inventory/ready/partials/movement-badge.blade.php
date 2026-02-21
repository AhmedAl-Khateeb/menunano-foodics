@php
    $badges = [
        'purchase' => 'bg-success-soft',
        'sale' => 'bg-info-soft',
        'waste' => 'bg-danger-soft',
        'adjustment' => 'bg-warning-soft',
    ];
    $icons = [
        'purchase' => 'fa-arrow-down',
        'sale' => 'fa-arrow-up',
        'waste' => 'fa-trash',
        'adjustment' => 'fa-sliders-h',
    ];
    $labels = [
        'purchase' => 'شراء / توريد',
        'sale' => 'عملية بيع',
        'waste' => 'هالك / تالف',
        'adjustment' => 'تسوية جرد',
    ];
    
    $type = $type ?? 'adjustment';
    $isIconOnly = $iconOnly ?? false;
@endphp

@if($isIconOnly)
    <div class="d-flex align-items-center justify-content-center rounded-circle {{ $badges[$type] ?? 'bg-light' }}" style="width: 32px; height: 32px;">
        <i class="fas {{ $icons[$type] ?? 'fa-circle' }} text-xs"></i>
    </div>
@else
    <span class="badge {{ $badges[$type] ?? 'bg-secondary' }} px-3 py-2">
        <i class="fas {{ $icons[$type] ?? 'fa-circle' }} ms-1"></i>
        {{ $labels[$type] ?? $type }}
    </span>
@endif
