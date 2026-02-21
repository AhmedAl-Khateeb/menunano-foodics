<div class="bg-gray-50 rounded-3 p-3 mb-3 border border-light position-relative group-hover">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center gap-3">
            <div class="avatar avatar-sm bg-gradient-success shadow-sm text-center rounded-circle flex-shrink-0">
                <i class="fas fa-leaf text-white text-xs" style="margin-top: 10px;"></i>
            </div>
            <div>
                <h6 class="mb-1 font-weight-bold text-dark">{{ $recipe->ingredient->name }}</h6>
                <div class="d-flex align-items-center gap-2 text-xs text-muted">
                    <span>
                        <i class="fas fa-weight-hanging ms-1"></i>
                        {{ $recipe->quantity }} {{ $recipe->unit->name ?? '' }}
                    </span>
                    <span class="mx-1">|</span>
                    <span>
                        <i class="fas fa-money-bill-wave ms-1"></i>
                        @php
                            $cost = ($recipe->ingredient->inventory->purchase_price ?? 0) * $recipe->quantity;
                        @endphp
                        {{ number_format($cost, 2) }} ج (تكلفة تقديرية)
                    </span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('inventory.composite.recipe.remove', $recipe->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('هل أنت متأكد من حذف هذا المكون؟')" title="حذف المكون">
                <i class="far fa-trash-alt text-lg"></i>
            </button>
        </form>
    </div>
    <div class="mt-2">
        <div class="d-flex justify-content-between text-xxs text-muted mb-1">
            <span>المخزون المتوفر: {{ $recipe->ingredient->inventory->current_quantity ?? 0 }}</span>
        </div>
        <div class="progress" style="height: 4px;">
            @php
                $current = $recipe->ingredient->inventory->current_quantity ?? 0;
                $percent = ($current > 0) ? min(100, ($current / 100) * 100) : 0;
                $needed = $recipe->quantity;
                $ratio = $needed > 0 ? ($current / $needed) : 0;
                $color = $ratio < 10 ? 'bg-warning' : 'bg-success';
                if($ratio < 1) $color = 'bg-danger';
            @endphp
            <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $percent }}%"></div>
        </div>
    </div>
</div>
